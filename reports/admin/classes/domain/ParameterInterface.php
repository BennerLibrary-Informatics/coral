<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author bgarcia
 */
interface ParameterInterface {
    public function fetchValue();
    public function process();
    public function htmlForm();
    public function htmlDisplay();
    public function ajax_getChildUpdate();
    public function ajax_getChildParameters();
}
