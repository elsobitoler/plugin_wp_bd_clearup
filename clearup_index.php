<?php
/*
Plugin Name: ClearUp
Description: Clear database on plugin deactivation.
Version: 1.0
Author: Your Name
License: GPL2
*/

// Регистрация хука, который будет вызываться при деактивации плагина
register_deactivation_hook( __FILE__, 'clearup_deactivation_hook' );

// Функция, вызываемая при деактивации плагина
function clearup_deactivation_hook() {
    // Проверяем, что все плагины отключены
    if (get_option('active_plugins')) {
        return;
    }

    // Выполняем очистку базы данных
    clearup_cleanup_database();
}

// Функция для очистки базы данных
function clearup_cleanup_database() {
    // Проверяем, что текущий пользователь имеет достаточные права для доступа к базе данных
    if (!current_user_can('activate_plugins')) {
        return;
    }

    // Получаем глобальный объект $wpdb, который предоставляет доступ к базе данных WordPress
    global $wpdb;

    // Указываем таблицы, которые нужно очистить
    $tables_to_clear = array(
        $wpdb->prefix . 'table1',
        $wpdb->prefix . 'table2',
        // Добавьте здесь остальные таблицы, которые нужно очистить
    );

    // Очищаем каждую таблицу
    foreach ($tables_to_clear as $table) {
        // Формируем SQL-запрос для удаления всех записей из таблицы
        $query = "TRUNCATE TABLE $table";
        
        // Выполняем запрос
        $wpdb->query($query);
    }
}
