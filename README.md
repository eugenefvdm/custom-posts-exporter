# Custom Posts Exporter

A WordPress plugin that exports custom post types in JSON format.

The plugin has two settings:

- Name of the Custom Post Type
- A `limit` that can be set to reduce the number of results returned

API endpoint: `https://example.com/wp-json/custom-posts-exporter/v1/fetch/`

If all is working, you should get a JSON response with the Custom Post Type data, such as the example below:

```json
{
  "status": "success",
  "data": [
    {
      "post_id": "5962",
      "title": "Virtualmin ERR_SSL_PROTOCOL_ERROR",
      "slug": "virtualmin-err_ssl_protocol_error",
      "content": "This is some content.",
      "category": "Control Panels",
      "category_slug": "control-panels",
      "tags": [
        "virtualmin",
        "ssl",
        "generate-letsencrypt",
        "enable-feature"
      ],
      "created_at": "2023-11-08 11:11:47",
      "updated_at": "2023-11-09 09:39:51",
      "seo_description": "This article will rank #1 at Google."
    },
    {
      "post_id": "5961",
      "title": "How to create a live snapshot of a running KVM virtual machine",
      "slug": "how-to-create-a-live-snapshot-of-a-running-kvm-virtual-machine",
      "content": "This is some more content.",
      "tags": [
        "qcow2",
        "virsh",
        "snapshot"
      ],
      "category": "Virtualization",
      "category_slug": "virtualization",
      "created_at": "2023-11-04 11:29:29",
      "updated_at": "2023-11-04 11:35:04"
    }
  ]
}
```

If you have RankMath installed, and you have created an SEO description, this will be included as `seo_description` in the JSON response.

## Installation

Copy the files to `wp-content/plugins/custom-posts-exporter/` and activate the plugin.

## Support

I'm happy to provide support for this plugin. Please contact me on eugene (at) fintechsystems.net or +27 82 309-6710.

## Todo

Submit to WordPress: https://wordpress.org/plugins/developers/add/