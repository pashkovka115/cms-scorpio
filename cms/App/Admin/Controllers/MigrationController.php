<?php


namespace App\Admin\Controllers;


use Crm\FileSystem\File;
use Crm\Route\Request;
use Crm\Route\Route;

class MigrationController extends Controller
{
    protected $migrationsPath;
    protected File $file;
    const MIGRATE_PREFIX = 'Migrate_';


    public function __construct()
    {
        parent::__construct();

        $this->migrationsPath = base_path() . '/App/Migrations';
        $this->file = new File($this->migrationsPath);
    }


    public function index()
    {
        $files = $this->file->listDir();

        echo $this->view->template('migrations.index', ['files' => $files]);
    }


    public function store(Request $request)
    {
        if ($request->hasInput('name')){
            // name 000000__d_m_Y_H:i:s_table_name
            $postfix_migration = date('__d_m_Y_H_i_s_');
            $table_name = str_replace(' ', '', $request->input('name'));

            $migrations = $this->file->listDir('*__*');
            $last_migrat = array_pop($migrations);
            $split = explode('__', basename($last_migrat));

            if (isset($split[0]) and ((int)$split[0] > 0)){
                $new_num = (string)(1 + (int)$split[0]);
            }else{
                $new_num = '100000';
            }

            $new_name = $this->file->getPath() . '/' . $new_num . $postfix_migration . $table_name;

            $stub = base_path() . '/Crm/stubs/migrations/table_create.stub';
            if (file_exists($stub)){
                $stub = file_get_contents($stub);
                $migrate_name = self::MIGRATE_PREFIX . basename($new_name);
                $stub = str_replace('{{migrate_name}}', $migrate_name, $stub);
                $stub = str_replace('{{table_name}}', "'$table_name'", $stub);

                file_put_contents($new_name . '.php', $stub);
            }

        }

        redirect(Route::getInstance()->name('scorpio.migrations.index'));
    }


    public function destroy(Request $request)
    {
        if ($request->hasInput('destroy') and $request->hasInput('file_name')){
            if (file_exists($request->input('file_name'))){
                unlink($request->input('file_name'));
            }
        }

        redirect(Route::getInstance()->name('scorpio.migrations.index'));
    }


    public function up(Request $request)
    {
        if ($request->hasInput('up') and $request->hasInput('file_name')) {
            $file_name = $request->input('file_name');
            if ($file_name and ($class = $this->getMigrationClass($file_name))) {
                (new $class())->up();
            }
        }

        redirect(Route::getInstance()->name('scorpio.migrations.index'));
    }


    public function upAll()
    {
        foreach ($this->file->listDir('*__*') as $file_name){
            if ($file_name and ($class = $this->getMigrationClass($file_name))) {
                (new $class())->up();
            }
        }

        redirect(Route::getInstance()->name('scorpio.migrations.index'));
    }


    public function down(Request $request)
    {
        if ($request->hasInput('down') and $request->hasInput('file_name')) {
            $file_name = $request->input('file_name');
            if ($file_name and ($class = $this->getMigrationClass($file_name))) {
                (new $class())->down();
            }
        }

        redirect(Route::getInstance()->name('scorpio.migrations.index'));
    }


    public function downAll()
    {
        foreach ($this->file->listDir('*__*') as $file_name){
            if ($file_name and ($class = $this->getMigrationClass($file_name))) {
                (new $class())->down();
            }
        }

        redirect(Route::getInstance()->name('scorpio.migrations.index'));
    }


    protected function getMigrationClass($file_name)
    {
        if (file_exists($file_name)){
            require $file_name;
            $class = basename($file_name);
            $class = self::MIGRATE_PREFIX . explode('.', $class)[0];

            return $class;
        }

        return false;
    }
}