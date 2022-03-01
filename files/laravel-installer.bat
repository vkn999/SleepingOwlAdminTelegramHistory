@echo off
set sDir=%~1

if defined sDir (
    echo Start to install Laravel with additional packages to: [%sDir%]
    SET COMPOSER_MEMORY_LIMIT=-1
    @echo on
    composer create-project --prefer-dist laravel/laravel %1
    cd %1
    composer install
    composer require barryvdh/laravel-debugbar barryvdh/laravel-ide-helper laravelcollective/html laravelrus/sleepingowl:dev-development
    @echo off
) else (
    echo Usage: %~nx0 ^<directory^>
)

endlocal
exit /b 0