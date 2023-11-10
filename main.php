<?php

add_action('rest_api_init', 'register_custom_endpoint');

function register_custom_endpoint() {
    register_rest_route('custom-post-type-export/v1', '/all/', [
        'methods'  => 'GET',
        'callback' => 'get_exported_data',
    ]);
}

function get_exported_data() {
    $post_type = get_option('custom_posts_exporter_post_type');
    $limit = get_option('custom_posts_exporter_limit');

    debugger("get_exported_data() was called for post_type '$post_type' and a limit of '$limit'.");

    $data = get_custom_post_types($post_type, $limit);

    if ($data == []) {
        $response = [
            'status' => 'error',
            'data'   => 'No data found',
        ];

        return new WP_REST_Response($response, 404);
    }

    $response = [
        'status' => 'success',
        'data'   => $data,
    ];

    return new WP_REST_Response($response, 200);
}

function get_custom_post_types($post_type, $limit) {
    global $wpdb;

    $data = [];

    $query1 = "
        SELECT
          p.ID,
          p.post_title as title,
          p.post_name as slug,
          p.post_date,
          p.post_modified,
          p.post_content,
          GROUP_CONCAT(tt.taxonomy) as types,
          GROUP_CONCAT(t.name) as type_values,
          GROUP_CONCAT(t.slug) as t_slugs
        FROM wp_posts p
          LEFT JOIN wp_term_relationships tr ON p.ID = tr.object_id
          LEFT JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
          LEFT JOIN wp_terms t ON tt.term_id = t.term_id
        WHERE p.post_type = '$post_type'
          GROUP BY p.ID
          ORDER BY p.post_date DESC          
    ";

    if ($limit) {
        $query1 .= "LIMIT $limit";
    }

    $results = $wpdb->get_results($query1);

    if (empty($results)) {
        return [];
    }

    $i = 0;
    foreach($results as $result) {
        $data[$i]['post_id'] = $result->ID;
        $data[$i]['title'] = $result->title;
        $data[$i]['slug'] = $result->slug;

        $data[$i]['content'] = $result->post_content;

        $typesArray = explode(',', $result->types);
        $valuesArray = explode(',', $result->type_values);
        $categorySlug = explode(',', $result->t_slugs);

        $j = 0;
        $k = 0;
        foreach($typesArray as $type) {
            if ($type == 'knowledgebase_categories') {
                $data[$i]['category'] = $valuesArray[$j];

                $data[$i]['category_slug'] = $categorySlug[$j];
            }

            if ($type == 'knowledgebase_tags') {
                $data[$i]['tags'][$k] = $valuesArray[$j];

                $k++;
            }

            $j++;
        }

        $data[$i]['created_at'] = $result->post_date;
        $data[$i]['updated_at'] = $result->post_modified;

        $i++;
    }

    $query2 = "
        SELECT
          m.meta_id,
          m.post_id,
          m.meta_key,
          m.meta_value
        FROM wp_postmeta m
        WHERE m.meta_key = 'rank_math_description';
    ";

    $results2 = $wpdb->get_results($query2);

    foreach($results2 as $result2) {
        $key = array_search($result2->post_id, array_column($data, 'id'));
        $data[$key]['seo_description'] = $result2->meta_value;
    }

    return $data;
}