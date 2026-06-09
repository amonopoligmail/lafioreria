# Script di Automazione Build & Deploy ---Powershell.exe -ExecutionPolicy Bypass -File .\03.gitCommit.ps1
Write-Host "--- Inizio procedura di Commit ---" -ForegroundColor Cyan

# 1. Aggiornamento dal repository Git
Write-Host "> Eseguendo Git Add..." -ForegroundColor Yellow
git add . 

# Controlla se l'ultimo comando (git) è fallito
if ($LASTEXITCODE -ne 0) {
    Write-Error "Errore durante il Git Add. Procedura interrotta."
    exit $LASTEXITCODE
}
Write-Host "> Eseguendo Git Commit..." -ForegroundColor Yellow
git commit -am "Aggiunte Modifiche Cursor odierne massive"
if ($LASTEXITCODE -ne 0) {
    Write-Warning "Errore durante il Git commit. Procedura interrotta."
    exit $LASTEXITCODE
}
Write-Host "> Eseguendo Git Push..." -ForegroundColor Yellow

#git push --set-upstream origin main
git push origin main --force
if ($LASTEXITCODE -ne 0) {
    Write-Error "Errore durante il Git Push. Procedura interrotta."
    exit $LASTEXITCODE
}
Write-Host "--- Procedura completata con successo! ---" -ForegroundColor Green
