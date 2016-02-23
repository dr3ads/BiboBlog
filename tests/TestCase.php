<?php


use Illuminate\Support\Facades\DB;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://biboblog.dev';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * @return string
     */
    public function login()
    {
        $token = $this->post('/auth/signin', [
            'username'     => '123456',
            'password' => '123456'
        ])->response->getContent();

        return $token;
    }

    public function getDatabaseName(){
        return DB::getDatabaseName();
    }

    /**
     * @param $table_name
     */
    public function renameTable($table_name)
    {
        if ( ! Schema::hasTable($table_name . '_test')) {
            Schema::rename($table_name, $table_name . '_test');
        }
    }

    /**
     * @param $table_name
     * @param $table_id
     * $table_id optional
     */
    public function rollbackRenameTable($table_name, $table_id = 0)
    {
        if ( ! Schema::hasTable($table_name)) {
            Schema::rename($table_name . '_test', $table_name);
        }
        $table_id === 0 ? : DB::table($table_name)->where('id', '=', $table_id)->delete();
    }

    /**
     * @param $table_name
     * @return mixed
     */
    public function getLatestInsertedData($table_name)
    {
        $latestId = DB::table($table_name)->orderBy('id', 'desc')->first();

        return $latestId->id;
    }

    /**
     * This will return primary key as an id
     * @param $table
     * @return mixed
     */
    public function getTableId($table)
    {
        $primary_id = DB::table($table)->first();

        return $primary_id->id;
    }

    /**
     * @param $table
     * @param $column
     * @param $order
     * @return mixed
     */
    public function getTableOrderById($table, $column, $order)
    {
        $primary_id = DB::table($table)->orderBy($column, $order)->first();

        return $primary_id->id;
    }

    /**
     * This will return a custom id
     * @param $table
     * @param $column
     * @return mixed
     */
    public function getCustomColumn($table, $column)
    {
        $column_id = DB::table($table)->first();

        return $column_id->$column;
    }

    /**
     * @param $table
     * @param $column
     * @param $where
     * @return mixed
     */
    public function getPrimaryCustomId($table, $column, $where)
    {
        $column_id = DB::table($table)->whereNull($where)->first();

        return $column_id->$column;
    }

}
