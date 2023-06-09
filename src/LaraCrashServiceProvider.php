<?php

namespace Sirajunnasihin\LaraCrash;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\HtmlString;

class LaraCrashServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        
    }

    public function boot(): void
    {
        View::composer('view', function () {
            // ...
        });
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name(name: 'filament-crash')
            ->hasConfigFile()
            ->hasInstallCommand(callable: fn (InstallCommand $command) => $command->publishConfigFile());
    }

    public function packageBooted(): void
    {
        /** @var string $dueDate */
        $dueDate = config(key: 'filament-crash.due_date');

        /** @var string $daysDeadline */
        $daysDeadline = config(key: 'filament-crash.deadline_after_due_date');

        Filament::registerRenderHook(
            name: 'scripts.end',
            callback: fn () => new HtmlString(html: "
                <script>
                    (function(){
                        const dueDate = new Date('{$dueDate}');
                        let daysDeadline = {$daysDeadline};
    
                        const current_date = new Date();
                        const utc1 = Date.UTC(dueDate.getFullYear(), dueDate.getMonth(), dueDate.getDate());
                        const utc2 = Date.UTC(current_date.getFullYear(), current_date.getMonth(), current_date.getDate());
                        const days = Math.floor((utc2 - utc1) / (1000 * 60 * 60 * 24));
    
                        if(days > 0) {
                            const daysLate = daysDeadline-days;
                            let opacity = (daysLate*100/daysDeadline)/100;
                                opacity = (opacity < 0) ? 0 : opacity;
                                opacity = (opacity > 1) ? 1 : opacity;
                            if(opacity >= 0 && opacity <= 1) {
                                document.getElementsByTagName('BODY')[0].style.opacity = opacity;
                            }
                        }
                    })()
                </script>
            "));
    }
}