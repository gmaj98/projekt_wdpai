<?php

class Slope {
    public int $id;
    public string $name;
    public string $location;
    public float $latitude;
    public float $longitude;
    public bool $level_green;
    public bool $level_blue;
    public bool $level_red;
    public bool $level_black;
    public bool $status;

    public function __construct(array $row) {
        $this->id = (int)$row['id'];
        $this->name = $row['name'];
        $this->location = $row['location'];
        $this->latitude = (float)$row['latitude'];
        $this->longitude = (float)$row['longitude'];
        $this->level_green = (bool)$row['level_green'];
        $this->level_blue = (bool)$row['level_blue'];
        $this->level_red = (bool)$row['level_red'];
        $this->level_black = (bool)$row['level_black'];
        $this->status = (bool)$row['status'];
    }

    public function toArray(): array {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "location" => $this->location,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
            "level_green" => $this->level_green,
            "level_blue" => $this->level_blue,
            "level_red" => $this->level_red,
            "level_black" => $this->level_black,
            "status" => $this->status,
        ];
    }
}
