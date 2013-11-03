<?php
    CroogoRouter::connect('/weather', array('plugin' => 'noaa', 'controller' => 'weathers', 'action' => 'index'));
