@php
    /**
     * @var Exception $exception
     * @var Job $job
     * @var string $content
     */
    use Illuminate\Contracts\Queue\Job;
@endphp
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <style>{!! $css ?? '' !!}</style>
    </head>
    <body>
        {!! 'Job - ' . $job->resolveName() !!}<br>
        {!! 'Code - ' . $exception->getCode() !!}<br>
        {!! 'File - ' . $exception->getFile() !!}<br>
        {!! 'Line - ' . $exception->getLine() !!}<br>
        {!! 'Message - ' . $exception->getMessage() !!}<br>
        Trace:
        {!! $content ?? '' !!}
    </body>
</html>
