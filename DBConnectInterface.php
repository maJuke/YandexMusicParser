<?php

interface DBConnectInterface {
    public function getConnection(): mysqli;
}