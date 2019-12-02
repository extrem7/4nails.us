<?php

require_once "includes/helpers.php";
require_once "classes/ThemeBase.php";
require_once "classes/ThemeWoo.php";

class Theme extends ThemeBase
{
    public $woo;

    protected function __construct()
    {
        parent::__construct();
        $this->woo = new ThemeWoo();
    }

    public function views()
    {
        return new class
        {
            public function tooltip()
            {
                get_template_part('views/tooltip');
            }

            public function miniCart()
            {
                get_template_part('views/miniCart');
            }
        };
    }

    public function pagination()
    {
        $prev = file_get_contents(path() . 'assets/img/icons/arrow_l.svg');
        $next = file_get_contents(path() . 'assets/img/icons/arrow_l.svg');
        the_posts_pagination([
            'show_all' => false,
            'end_size' => 2,
            'mid_size' => 2,
            'prev_next' => true,
            'prev_text' => $prev,
            'next_text' => $next,
        ]);
    }

}