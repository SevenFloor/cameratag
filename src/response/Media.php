<?php
/**
 * Created by PhpStorm.
 * User: ignatenkovnikita
 * Web Site: http://IgnatenkovNikita.ru
 */

namespace cameratag\response;


/**
 * Class Media
 * @package cameratag\response
 */
/**
 * Class Media
 * @package cameratag\response
 */
class Media extends AbstractResponse
{
    /**
     *
     */
    const TYPE_PHOTO = 'photo';
    /**
     *
     */
    const TYPE_MP4 = 'mp4';
    /**
     *
     */
    const TYPE_MP3 = 'mp3';
    /**
     * @var
     */
    public $width;
    /**
     * @var
     */
    public $height;
    /**
     * @var
     */
    public $length;
    /**
     * @var
     */
    public $media_type;
    /**
     * @var
     */
    public $name;
    /**
     * @var
     */
    public $state;
    /**
     * @var array
     */
    public $urls = [];
}