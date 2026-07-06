<?php
namespace App;

class FileEntity
{
    // For ids I selected `string` as variable type, because it is not known what structure
    // id has. So selecting `string` jsut because this is more flexible type for ids.

    public string $id;

    public string $tenantId;

    public string $content;
    
    public array $metadata;
}
?>