<?php

namespace Tilto\Commentable\Filament\Concerns;

trait HasAttachments
{
    protected string $fileAttachmentsDisk = 'public';

    protected string $fileAttachmentsDirectory = 'comments';

    protected array $fileAttachmentsAcceptedFileTypes = [];

    protected int $fileAttachmentsMaxSize = 5120;

    public function fileAttachmentsDisk(string $disk): static
    {
        $this->fileAttachmentsDisk = $disk;

        return $this;
    }

    public function getFileAttachmentsDisk(): string
    {
        return $this->fileAttachmentsDisk;
    }

    public function fileAttachmentsDirectory(string $directory): static
    {
        $this->fileAttachmentsDirectory = $directory;

        return $this;
    }

    public function getFileAttachmentsDirectory(): string
    {
        return $this->fileAttachmentsDirectory;
    }

    public function fileAttachmentsAcceptedFileTypes(array $fileTypes): static
    {
        $this->fileAttachmentsAcceptedFileTypes = $fileTypes;

        return $this;
    }

    public function getFileAttachmentsAcceptedFileTypes(): array
    {
        return $this->fileAttachmentsAcceptedFileTypes;
    }

    public function fileAttachmentsMaxSize(int $sizeInKilobytes): static
    {
        $this->fileAttachmentsMaxSize = $sizeInKilobytes;

        return $this;
    }

    public function getFileAttachmentsMaxSize(): int
    {
        return $this->fileAttachmentsMaxSize;
    }
}
