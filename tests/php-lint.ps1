$ErrorActionPreference = 'Stop'

$php = Get-Command php -ErrorAction SilentlyContinue
if (-not $php) {
    throw 'PHP is required to run the syntax checks. Install PHP or run the checks in CI.'
}

$files = @(Get-ChildItem -Path (Join-Path $PSScriptRoot '..\src') -Recurse -File -Filter '*.php')
if ($files.Count -eq 0) {
    throw 'No PHP files were found under src.'
}

$failed = @()
foreach ($file in $files) {
    & $php.Source -l $file.FullName
    if ($LASTEXITCODE -ne 0) {
        $failed += $file.FullName
    }
}

if ($failed.Count -gt 0) {
    throw ("PHP syntax checks failed for: " + ($failed -join ', '))
}

Write-Output ("PHP syntax checks passed for {0} files." -f $files.Count)
