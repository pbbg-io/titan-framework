<?php

namespace PbbgIo\TitanFramework\Commands;

use Illuminate\Console\Command;

class MakeExtension extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'titan:extension:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new extension';

    /**
     * The extension directory
     *
     * @var string
     */
    private $extensionDirectory = '';

    /**
     * Answers to the questions
     *
     * @var array
     */
    private $answers = [];

    /**
     * A list of names based on author and name
     *
     * @var array
     */
    private $names = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->extensionDirectory = base_path('extensions');
    }

    /**
     * Ask some setup instructions
     *
     * @return void
     */
    private function askQuestions(): void
    {
        $this->askQuestion('name', 'What is the name of your extension?', 'Mdg-Dbdb76_nsDDD`');
        $this->askQuestion('author', 'Who is publishing this extension? Eg your name, team, company', 'pbbg');
        $this->askQuestion('email', 'What is your email?', 'youremail@domain.com');
        $this->askQuestion('description', 'Describe your extension');

        $this->setupNamesAndPaths();
        $this->info("You are creating an extension named '{$this->names['alpha_name']}' and you are publishing it under the name '{$this->names['alpha_author']}'");

        $correct = $this->askWithCompletion("Is this correct? [Y/n]", [
            'yes',
            'no',
        ], 'y');

        $exists = $this->extensionExists();
        if (in_array(strtolower($correct), ['y', 'yes'])) {
            if ($exists) {
                $this->error("Extension already exists");
                exit;
            }
        } else {
            $this->answers = [];
            $this->names = [];
            $this->askQuestions();
        }
    }

    /**
     * Sets up a bunch of names and paths for to help generate stubs
     */
    private function setupNamesAndPaths()
    {
        $description = $this->answers['description'];
        $email = $this->answers['email'];

        $name = $this->answers['name'];
        $alphaName = strtolower($name);
        $alphaName = preg_replace("/[^A-Za-z\-]/", '', $alphaName);
        $this->names['alpha_name'] = $alphaName;

        $author = $this->answers['author'];
        $alphaAuthor = strtolower($author);
        $alphaAuthor = preg_replace("/[^A-Za-z\-]/", '', $alphaAuthor);
        $this->names['alpha_author'] = $alphaAuthor;

        $this->names['namespace'] = 'Extensions\\' . \Str::studly($alphaAuthor) . '\\' . \Str::studly($alphaName);
        $this->names['folder'] = \Str::kebab($alphaAuthor) . '/' . \Str::kebab($alphaName);

        $this->names['view_namespace'] = \Str::kebab($alphaName);

        $this->names['package_name'] = $this->names['folder'];
        $this->names['package_description'] = $description;
        $this->names['package_author'] = $author;
        $this->names['package_author_email'] = $email;
        $this->names['package_friendly_name'] = $name;
        $this->names['package_namespace'] = str_replace('\\', '\\\\', $this->names['namespace']);

        $this->extensionDirectory = $this->extensionDirectory . '/' . $this->names['folder'] . '/';
    }

    /**
     * Ask a recurring question until an answer is given
     *
     * @param $key
     * @param $question
     * @param $default
     */
    private function askQuestion($key, $question, $default = null): void
    {
        while (!isset($this->answers[$key]) || strlen($this->answers[$key]) < 1) {
            $this->answers[$key] = trim($this->ask($question, $default));
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $this->info('First we just need to ask you a few questions to setup the boilerplate');
        $this->askQuestions();
        $this->createExtension();
        exec('composer dump-autoload');
        $this->info("Extension has been created, have fun building!");
    }

    /**
     * Check if the extension exists
     *
     * @return bool
     */
    private function extensionExists(): bool
    {
        return \File::exists($this->extensionDirectory);
    }

    private function createExtension()
    {
        // Creating the stubs
        \File::makeDirectory($this->extensionDirectory, 0755, true);
        \File::copyDirectory(dirname(dirname(__DIR__)) . '/resources/stubs/extension/author/extension-name',
            $this->extensionDirectory);

        $this->replaceStub('AdminController.php');
        $this->replaceStub('composer.json');
        $this->replaceStub('InstallController.php');
        $this->replaceStub('routes.php');
        $this->replaceStub('ServiceProvider.php');

    }

    private function replaceStub(string $file)
    {
        \File::move($this->extensionDirectory . $file . '.stub', $this->extensionDirectory . $file);
        $this->makeReplacements($file);
    }

    private function makeReplacements(string $file)
    {

        $fileName = $file;

        $contents = \File::get($this->extensionDirectory . $file);

        $replacements = [
            'namespace' => $this->names['namespace'],
            'view_namespace' => $this->names['view_namespace'],
            'package_name' => $this->names['package_name'],
            'package_description' => $this->names['package_description'],
            'package_author' => $this->names['package_author'],
            'package_author_email' => $this->names['package_author_email'],
            'package_friendly_name' => $this->names['package_friendly_name'],
            'package_namespace' => $this->names['package_namespace']
        ];

        foreach ($replacements as $key => $value) {
            $contents = str_ireplace('{{' . $key . '}}', $value, $contents);
        }

        \File::put($this->extensionDirectory . $fileName, $contents);
    }
}
