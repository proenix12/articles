Laravel Article Job Request
============


## List all articles
### Request

`GET /v1/articles`

### Response
    [
    {
        "id": 1,
        "title": "example title",
        "article_body": "example title",
        "article_photo_path": "/storage/uploads/61d67ab1cfdfcY7ZO9VpZI3lpyWfzqnAmx8AIOSMkXqvLT4D.jpg",
        "created_at": "2022-01-06T04:47:38.000000Z",
        "updated_at": "2022-01-06T05:14:25.000000Z",
        "tagged": [
            {
                "id": 16,
                "taggable_id": 1,
                "taggable_type": "App\\Models\\Article",
                "tag_name": "Example",
                "tag_slug": "example",
                "tag": {
                "id": 2,
                "slug": "example",
                "name": "Example",
                "suggest": 0,
                "count": 1,
                "tag_group_id": null,
                "description": null
            }
        ]
    }
]

## Create new article
### Request

`POST /v1/article/create`

- Form-data: `title, article_body, tag_name or tag_name[]", file`

### Response
    {"success":"Article Example was added"} or {"error":"Title is required"}

## Update article
### Request

`POST /v1/article/:id/update`

- Form-data: `title, article_body, tag_name or tag_name[]", file`

### Response
    {"success":"Article Example was updated"} or {"error":"something went wrong try again"} or {"error": "Article not found"}

## Search article
### Request

`POST /v1/article/search`

- Form-data: `tag_name or tag_name[]`

### Response
    [
        {
            "id": 1,
            "title": "example title",
            "article_body": "example title",
            "article_photo_path": "/storage/uploads/61d67ab1cfdfcY7ZO9VpZI3lpyWfzqnAmx8AIOSMkXqvLT4D.jpg",
            "created_at": "2022-01-06T04:47:38.000000Z",
            "updated_at": "2022-01-06T05:14:25.000000Z",
        }
    ]

## Delete article
### Request

`DELETE /v1/article/:id`

### Response
    {"success":"Article Example was deleted"} or {"error": "Article not found"}


## Article add tag
### Request

`POST /v1/article/:id/tag`
- Form-data: `tag_name`

### Response
    {"success":"'Tag:Example was added to Example article"} or {"error": "Article not found"}

## Article delete tag
### Request

`DELETE /v1/article/:id/tag`
- Form-data: `tag_name`

### Response
    {"success":"'Tag:Example was deleted from Example article"} or {"error": "Article not found"}
