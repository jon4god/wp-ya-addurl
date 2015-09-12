<?php
/*
Plugin Name: Yandex Addurl Admin Bar Widgets
Plugin URI:
Description: Work with addurl Yandex
Version: 0.1
Author: Evgeniy Kutsenko
Author URI: http://starcoms.ru
License: GPL2
*/

$server_name  = $_SERVER["SERVER_NAME"];
$request_uri  = $_SERVER["REQUEST_URI"];

function custom_toolbar_link($wp_admin_bar) {

  function get_check_URL() {
    $check_url = $server_name . $request_uri;
    if (substr($check_url, -1) == '/') {$check_url = substr($check_url, 0, -1);}
    if (substr($check_url, 0, 4) == 'www.') {$check_url = substr($check_url, 4);}
    $check_url = rawurlencode($check_url);
    return $check_url;
  }
  $linkforcheck = 'http://yandex.ru/yandsearch?text=url%3A%28www.'.get_check_URL().'%29+%7C+url%3A%28'.get_check_URL().'%29';

  function get_sent_URL() {
    $sent_url = $server_name . $request_uri;
    $sent_url = rawurlencode($sent_url);
    return $sent_url;
  }
  $linkforsent = 'http://webmaster.yandex.ru/addurl.xml?url='.get_sent_URL();

  $args = array(
    'id' => 'yandexaddurl',
    'title' => 'АДДУРИЛКА',
    'href' => 'http://webmaster.yandex.ru/addurl.xml',
    'meta' => array(
      'class' => 'yandexaddurl',
      'target' => '_blank',
      'title' => 'Перейти на Яндекс.AddUrl'
    )
  );
  $wp_admin_bar->add_node($args);

  $args = array(
    'id' => 'yandexurlcheck',
    'title' => 'Проверка ссылки',
    'href' => $linkforcheck,
    'parent' => 'yandexaddurl',
    'meta' => array(
      'class' => 'yandexurlcheck',
      'target' => '_blank',
      'title' => 'Проверка ссылки на индексацию в Яндексе'
    )
  );
  $wp_admin_bar->add_node($args);

  $args = array(
    'id' => 'yandexaddurlsent',
    'title' => 'Отправка ссылки',
    'href' => $linkforsent,
    'parent' => 'yandexaddurl',
    'meta' => array(
      'class' => 'yandexaddurlsent',
      'target' => '_blank',
      'title' => 'Отправляем ссылку в Яндекс.Вебмастер'
    )
  );
  $wp_admin_bar->add_node($args);
}

add_action('admin_bar_menu', 'custom_toolbar_link', 999);
