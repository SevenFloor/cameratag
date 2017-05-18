<?php
namespace cameratag\response;


/**
 * Class BaseObject
 * @package cameratag\response
 */
class BaseObject extends AbstractResponse
{
    /**
     * @var
     */
    public $uuid;
    /**
     * @var
     */
    public $preview_thumbnail_url;
    /**
     * @var
     */
    public $preview_full_thumbnail_url;
    /**
     * @var
     */
    public $state;
    /**
     * @var
     */
    public $name;
    /**
     * @var
     */
    public $description;
    /**
     * @var
     */
    public $type;
    /**
     * @var
     */
    public $app_uuid;
    /**
     * @var array
     */
    public $medias = [];
    /**
     * @var
     */
    public $created_at;
    /**
     * @var
     */
    public $percent_complete;
    /**
     * @var
     */
    public $publish_type;
    /**
     * @var
     */
    public $play_count;
    /**
     * @var array
     */
    public $metadata = [];
    /**
     * @var
     */
    public $recorded_from;
    /**
     * @var
     */
    public $browser;
    /**
     * @var
     */
    public $origin;
    /**
     * @var
     */
    public $client_version;
}