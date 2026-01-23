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

An extensive and very customizable package that adds commenting in Filament v4.5 and newer.

Inspired by and built upon code from the [Kirschbaum Commentions package](https://github.com/kirschbaum-development/commentions), but takes a different approach to commenting in Filament.

## Requirements

-   Laravel 11.x/12.x
-   PHP 8.2+
-   Filament 4.5+

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

### Setting up your models

To enable commenting functionality, you need to update your models as follows:

#### 1. Implement the Commenter contract

In your **User** model, implement the `Commenter` contract:

```php
use Tilto\Commentable\Contracts\Commenter;

class User extends Model implements Commenter
{
    // ...
}
```

#### 2. Implement the Commentable contract

In the model you want to make commentable (for example, `Post`), implement the `Commentable` contract and use the `HasComments` trait:

```php
use Tilto\Commentable\Traits\HasComments;
use Tilto\Commentable\Contracts\Commentable;

class Post extends Model implements Commentable
{
    use HasComments;
}
```

### Custom policy

You can define a custom policy for the `Comment` model to control who can create, update, or delete comments. First, create a new policy class (for example, `App\Policies\CommentPolicy`) and extend the default policy:

```php
namespace App\Policies;

use Tilto\Commentable\Contracts\Commenter;
use Tilto\Commentable\Models\Comment;
use Tilto\Commentable\Policies\CommentPolicy as CommentablePolicy;

class CommentPolicy extends CommentablePolicy
{
    public function create(Commenter $user): bool
    {
        // ...
    }

    public function update(Commenter $user, Comment $comment): bool
    {
        // ...
    }

    public function reply(Commenter $user, Comment $comment): bool
    {
        // ...
    }

    public function delete(Commenter $user, Comment $comment): bool
    {
        // ...
    }
}
```

Then, update the `comment.policy` value in your `config/commentable.php` file to point to your new policy:

```php
'comment' => [
    'model' => Tilto\Commentable\Models\Comment::class,
    'policy' => App\Policies\CommentPolicy::class,
],
```

This allows you to fully customize comment permissions to fit your application's requirements.

### Comment Component

You can add a comments section to your Filament Infolist using the `CommentsEntry` component:

```php
use Tilto\Commentable\Filament\Infolists\Components\CommentsEntry;

CommentsEntry::make('comments')
```

#### Button position

You can set the position of the "Add Comment" button using the `buttonPosition` method:

```php
CommentsEntry::make('comments')
    ->buttonPosition('right') // Options: 'left', 'right'
```

#### Toolbar buttons

You can customize the toolbar buttons using the `toolbarButtons` method, which uses Filament's built-in toolbar button options:

```php
CommentsEntry::make('comments')
    ->toolbarButtons([
        ['bold', 'italic', 'strike'],
        ['attachFiles'],
    ])
```

The default toolbar buttons are `bold`, `italic`, `strike`, and `attachFiles`.

#### Markdown Editor

Prefer writing comments in Markdown? Enable the Markdown editor with the `markdownEditor` method:

```php
CommentsEntry::make('comments')
    ->markdownEditor()
```

By default, comments use Filament's built-in rich text editor. Switching to the Markdown editor allows users to write and preview comments using Markdown syntax.

#### Mentions

From Filament 4.5+, mentions are supported. You can add mentions to the `CommentsEntry` just as you would with Filament's RichTextEditor:

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

To ensure mentions match Filament's default appearance, add the following CSS to your theme or `app.css` file:

```css
span[data-type="mention"] {
    @apply bg-primary-50 text-primary-600 dark:bg-primary-400/10 dark:text-primary-400 my-0 inline-block rounded px-1 font-medium whitespace-nowrap;
}
```

> [!NOTE]
> Mentionables are only supported when using the rich text editor. They are not available in the Markdown editor.

#### File Attachments

You can customize the file attachment behavior by chaining the following methods:

```php
CommentsEntry::make('comments')
    ->fileAttachmentsDisk('public') // Set the storage disk for attachments
    ->fileAttachmentsDirectory('comments') // Set the directory for attachments
    ->fileAttachmentsAcceptedFileTypes(['pdf', 'jpg', 'png']) // Set accepted file types
    ->fileAttachmentsMaxSize(5120) // Set max file size in kilobytes
```

#### Polling

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

#### Replies

You can enable replies to comments using the `nestable` method:

```php
CommentsEntry::make('comments')
    ->nestable() // Enable replies
```

## Testing

```bash
composer test
```

## Alternatives

If this package doesn't fully meet your needs, you might find these alternatives helpful:

-   [Kirschbaum Commentions](https://github.com/kirschbaum-development/commentions/tree/main/src)
-   [Laravel Comments by Spatie](https://laravel-comments.com)
-   [Beyondcode Comments](https://github.com/beyondcode/laravel-comments)
-   [Lakshan-Madushanka Laravel Comments](https://github.com/Lakshan-Madushanka/laravel-comments)

Each package provides unique features and approaches to commenting in Laravel. If this package is almost what you need but is missing some functionality, you can open a discussion or check out the alternatives listed above. One of them might have exactly what you're looking for.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Credits

-   [Matilda Smets](https://github.com/matildasmets)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
