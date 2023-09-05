<?php
Class UserLevel {
    private $userLevelNo;
    private $levelName;

    public function __construct($userLevelNo, $levelName) {
        $this->userLevelNo = $userLevelNo;
        $this->levelName = $levelName;        
    }

    public function getUserLevelNo() {
        return $this->userLevelNo;
    }
    public function setUserLevelNo($value) {
        $this->userLevelNo;
    }

    public function getLevelName() {
        return $this->levelName;
        return $this->levelName;
    }
    public function setLevelName($value) {
        $this->levelName;
    }
}