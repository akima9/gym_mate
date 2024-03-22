<?php

namespace App\Dtos;

use App\Dtos\BaseDto;

class BoardDto extends BaseDto
{
    protected $id;
    protected $title;
    protected $trainingDate;
    protected $trainingStartTime;
    protected $trainingEndTime;
    protected $trainingParts;
    protected $content;
    protected $status;
    protected $user_id;
    protected $gym_id;
    protected $created_at;
    protected $updated_at;

    public function __construct($request)
    {
        $this->bindToDto($request);
        $this->setUserId($request);
        $this->setGymId($request);
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the value of trainingDate
     */
    public function getTrainingDate()
    {
        return $this->trainingDate;
    }

    /**
     * Get the value of trainingStartTime
     */
    public function getTrainingStartTime()
    {
        return $this->trainingStartTime;
    }

    /**
     * Get the value of trainingEndTime
     */
    public function getTrainingEndTime()
    {
        return $this->trainingEndTime;
    }

    /**
     * Get the value of trainingParts
     */
    public function getTrainingParts()
    {
        return $this->trainingParts;
    }

    /**
     * Get the value of content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the value of user_id
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($request)
    {
        $this->user_id = $request->user()->id;
    }

    /**
     * Get the value of gym_id
     */
    public function getGymId()
    {
        return $this->gym_id;
    }

    public function setGymId($request)
    {
        $this->gym_id = $request->user()->gym_id;
    }

    /**
     * Get the value of created_at
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Get the value of updated_at
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}
