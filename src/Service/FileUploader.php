<?php

namespace App\Service;

use App\Entity\Media;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * FileUploader
 */
class FileUploader
{
    /**
     * @var string
     */
    private string $uploadDir;

    /**
     * @var string
     */
    private string $uploadAbsoluteDir;

    /**
     *@var string
     */
    private $uploadDirImages;

    /**
     *
     * @param string $uploadDir
     * @param string $uploadAbsoluteDir
     * @param string UploadDirImages
     */
    public function __construct(string $uploadDir, string $uploadAbsoluteDir, $uploadDirImages)
    {
        $this->uploadDir = $uploadDir;
        $this->uploadAbsoluteDir = $uploadAbsoluteDir;
        $this->uploadDirImages = $uploadDirImages;
    }
        
    /**
     * @param Media $media
     */
    public function upload(Media $media): void
    {
        if ($media->getFile() instanceof UploadedFile) {
            $filename = sprintf("%s.%s", Uuid::v4(), $media->getFile()->getClientOriginalExtension());
            $media->getFile()->move($this->uploadAbsoluteDir, $filename);
            $media->setPath(sprintf("%s/%s", $this->uploadDir, $filename));
        }
    }

    /**
     * @param Media $media
     */
    public function removeFile(Media $media): void
    {
        $filesystem = new Filesystem();
        $filesystem->remove($this->uploadDirImages . $media->getpath());
    }
}
