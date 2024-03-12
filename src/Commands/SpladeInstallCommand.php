<?php

namespace ProtoneMedia\Splade\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Exception\RuntimeException;
use Symfony\Component\Process\Process;

class SpladeInstallCommand extends Command
{
    use InstallsSpladeExceptionHandler;
    use InstallsSpladeRouteMiddleware;

    public $signature = 'splade:install';

    public $description = 'Install the Splade components and resources';

    /**
     * Installs the Splade Route Middleware, the Exception Handler, the
     * required NPM packages and copies all boilerplate files into
     * the application.
     */
    public function handle(): int
    {
        // Tailwind Configuration...
        copy(__DIR__ . '/../../stubs/postcss.config.js', base_path('postcss.config.js'));

        (new Filesystem)->ensureDirectoryExists(base_path('routes'));
        (new Filesystem)->ensureDirectoryExists(resource_path('css'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/components'));

        (new Filesystem)->deleteDirectory(resource_path('sass'));

        copy(__DIR__ . '/../../stubs/routes/web.php', base_path('routes/web.php'));
        copy(__DIR__ . '/../../stubs/resources/views/root.blade.php', resource_path('views/root.blade.php'));

        $this->comment('All done');
        $this->comment('Execute "npm run dev" to start the Vite dev server.');

        return self::SUCCESS;
    }

    /**
     * End of line symbol.
     */
    public static function eol(): string
    {
        return windows_os() ? "\n" : PHP_EOL;
    }

    /**
     * Adds the SSR build step to the 'build' command.
     *
     * @return void
     */
    protected function updateNodeScript()
    {
        if (!file_exists(base_path('package.json'))) {
            return;
        }

        $packageFile = file_get_contents(base_path('package.json'));

        file_put_contents(
            base_path('package.json'),
            str_replace('"vite build"', '"vite build && vite build --ssr"', $packageFile)
        );
    }

    /**
     * Updates the "package.json" file.
     *
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (!file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . static::eol()
        );
    }

    /**
     * Run the given commands.
     *
     * @param  array  $commands
     * @return void
     */
    protected function runCommands($commands)
    {
        $process = Process::fromShellCommandline(implode(' && ', $commands), null, null, null, null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            try {
                $process->setTty(true);
            } catch (RuntimeException $e) {
                $this->output->writeln('  <bg=yellow;fg=black> WARN </> ' . $e->getMessage() . PHP_EOL);
            }
        }

        $process->run(function ($type, $line) {
            $this->output->write('    ' . $line);
        });
    }
}
