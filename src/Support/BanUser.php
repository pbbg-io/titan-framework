<?php

namespace PbbgIo\Titan\Support;

use PbbgIo\Titan\Ban;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;

class BanUser
{
    private $user;
    private $forever;
    private $banUntil;
    private $reason;
    private $type;
    /**
     * @return \App\User $user
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * @param Model $user
     * @return BanUser
     */
    public function setUser($user)
    {
        $this->user = $user;
        $this->setType($user);
        return $this;
    }
    /**
     * @return boolean
     */
    public function getForever()
    {
        return $this->forever;
    }
    /**
     * @param boolean $forever
     * @return BanUser
     */
    public function setForever($forever)
    {
        $this->forever = $forever;
        return $this;
    }
    /**
     * @return \DateTime
     */
    public function getBanUntil()
    {
        return $this->banUntil;
    }
    /**
     * @param \DateTime $banUntil
     * @return BanUser
     */
    public function setBanUntil($banUntil)
    {
        $this->banUntil = $banUntil;
        return $this;
    }
    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }
    /**
     * @param string $reason
     * @return BanUser
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getType()
    {
        return get_class($this->getUser());
    }
    /**
     * @param Model $type
     * @return BanUser
     */
    public function setType(Model $type)
    {
        $this->type = get_class($type);
        return $this;
    }
    /**
     * @return bool
     */
    public function isBanned()
    {
        $search = Ban::where(function(Builder $query) {
            $query->where('bannable_id', $this->getUser()->id);
            $query->where('bannable_type', $this->getType());
        })->exists();
        return $search;
    }
    /**
     * @return bool|Ban|\Illuminate\Database\Eloquent\Model
     */
    public function placeBan()
    {
        $bannedUser = Ban::updateOrCreate(
            ['bannable_id' => $this->getUser()->id, 'bannable_type' => $this->getType()],
            ['reason' => $this->getReason(),
                'ban_until' => $this->getBanUntil(),
                'forever' => $this->getForever()]);
        if ($bannedUser->exists()) {
            return $bannedUser;
        } else {
            return false;
        }
    }
    /**
     * @return boolean
     * @throws \Exception
     */
    public function removeBan()
    {
        return Ban::where(function(Builder $query) {
            $query->where('bannable_id', $this->getUser()->id);
            $query->where('bannable_type', $this->getType());
        })->delete();
    }
    /**
     * @param string|null $type
     * @return \Illuminate\Support\Collection
     */
    public function getUsersBanned(string $type = null)
    {
        $banned = Ban::with(['bannable']);
        if($type != null) {
            $banned->where('bannable_type', '=', $type);
        }
        return collect($banned->get());
    }
}
