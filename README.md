<div align="left">
    <a href="https://tilto.nl">
      <picture>
        <img alt="Cover" src="/cover.webp">
      </picture>
    </a>

<br />
<br />

[![Latest Version on Packagist](https://img.shields.io/packagist/v/businesstilto/commentable.svg?style=for-the-badge)](https://packagist.org/packages/businesstilto/commentable)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=for-the-badge)](LICENSE.md)
[![Quality Score](https://img.shields.io/scrutinizer/g/businesstilto/commentable.svg?style=for-the-badge)](https://scrutinizer-ci.com/g/businesstilto/commentable)
[![Total Downloads](https://img.shields.io/packagist/dt/businesstilto/commentable.svg?style=for-the-badge)](https://packagist.org/packages/businesstilto/commentable)

</div>

A lightweight and easy to use package that adds commenting in Filament v4.5 and newer.

Inspired by and built upon code from the [Kirschbaum Commentions package](https://github.com/kirschbaum-development/commentions), but takes a different approach to commenting in Filament.

## Installation

You can install the package via composer:

```bash
composer require businesstilto/commentable
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="commentable-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="commentable-config"
```

You can publish the translation files with:

```bash
php artisan vendor:publish --tag="commentable-translations"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="commentable-views"
```

This is the contents of the published config file:

```php
return [

    'commenter' => [
        'model' => '',
    ],

    'comment' => [
        'model' => Tilto\Commentable\Models\Comment::class,
        'policy' => Tilto\Commentable\Policies\CommentPolicy::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */
    'events' => [
        'comment_created_enabled' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */
    'notifications' => [
        'created' => [
            'enabled' => false,
            'channels' => ['database'],
        ],
        'mentions' => [
            'enabled' => true,
            'channels' => ['database'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Event Listeners
    |--------------------------------------------------------------------------
    */
    'listeners' => [
        'comment_created' => Tilto\Commentable\Listeners\HandleCommentCreated::class,
        'comment_mentioned' => Tilto\Commentable\Listeners\HandleCommentMentioned::class,
    ],
];

```

## Usage

You can add a comments section to your Filament Infolist using the `CommentsEntry` component:

```php
use Tilto\Commentable\Filament\Infolists\Components\CommentsEntry;

CommentsEntry::make('comments')
```

### Button position

You can set the position of the "Add Comment" button using the `buttonPosition` method:

```php
CommentsEntry::make('comments')
    ->buttonPosition('right') // Options: 'left', 'right'
```

### Toolbar buttons

You can customize the toolbar buttons using the `toolbarButtons` method, which uses Filament's built-in toolbar button options:

```php
CommentsEntry::make('comments')
    ->toolbarButtons([
        ['bold', 'italic', 'strike'],
        ['attachFiles'],
    ])
```

The default toolbar buttons are:

```php
[
    ['bold', 'italic', 'strike'],
    ['attachFiles'],
]
```

### Markdown Editor

Prefer writing comments in Markdown? Enable the Markdown editor with the `markdownEditor` method:

```php
CommentsEntry::make('comments')
    ->markdownEditor()
```

By default, comments use Filament’s built-in rich text editor. Switching to the Markdown editor allows users to write and preview comments using Markdown syntax.

## Mentionables

From Filament 4.5+, mentionables are supported. You can add mentionables to the `CommentsEntry` just as you would with Filament's RichTextEditor:

```php
CommentsEntry::make('comments')
    ->mentions([
        MentionProvider::make('@')
            ->items([
                1 => 'Jane Doe',
                2 => 'John Smith',
            ]),
    ])
```
> [!NOTE]
> Mentionables are only supported when using the rich text editor. They are not available in the Markdown editor.

### File Attachments

You can customize the file attachment behavior by chaining the following methods:

```php
CommentsEntry::make('comments')
    ->fileAttachmentsDisk('public') // Set the storage disk for attachments
    ->fileAttachmentsDirectory('comments') // Set the directory for attachments
    ->fileAttachmentsAcceptedFileTypes(['pdf', 'jpg', 'png']) // Set accepted file types
    ->fileAttachmentsMaxSize(5120) // Set max file size in kilobytes
```

### Polling

You can enable polling to automatically refresh the comments list at a specified interval:

```php
CommentsEntry::make('comments')
    ->pollingInterval('5s') // Refresh every 5 seconds
```

Or by using the default interval:

```php
CommentsEntry::make('comments')
    ->enablePolling() // Refresh using the default interval
```

### Replies

You can enable replies to comments using the `nestable` method:

```php
CommentsEntry::make('comments')
    ->nestable() // Enable replies
```

## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Credits

-   [Matilda Smets](https://github.com/matildasmets)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
