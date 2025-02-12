<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateDealsStatusEnum extends Migration
{
    public function up()
    {
        // Обновляем столбец status с новыми значениями
        DB::statement("ALTER TABLE deals MODIFY COLUMN status ENUM(
            'Ждем ТЗ',
            'Планировка',
            'Коллажи',
            'Визуализация',
            'Рабочка/сбор ИП',
            'Проект готов',
            'Проект завершен',
            'Проект на паузе',
            'Возврат'
        ) NOT NULL DEFAULT 'Ждем ТЗ'");
    }

    public function down()
    {
        // В методе down можно вернуть старые значения (при необходимости)
        DB::statement("ALTER TABLE deals MODIFY COLUMN status ENUM(
            'В работе',
            'Завершенный',
            'На потом',
            'Регистрация',
            'Бриф прикриплен',
            'Поддержка',
            'Активный'
        ) NOT NULL DEFAULT 'В работе'");
    }
}
