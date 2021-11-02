<?php

class Model extends Db {

    public function find($id, $view = null) {
        if ($view == null) {
            return $this->read_single($id);
        } else {
            return $this->read_single($id, $view);
        }
    }

    public function find_by($data, $view = null) {
        if ($view == null) {
            return $this->read_single_by($data);
        } else {
            return $this->read_single_by($data, $view);
        }
    }

}