Forked from https://github.com/splittingred/Redirector

*** Now creates 301 redirect records automatically whenever a resource alias is modified ***

- Modified build.transport.php to support two new events, OnDocFormRender and OnDocFormSave
- Modified plugin.redirector.php to capture alias prior to save (OnDocFormRender). If the alias has changed and the system settings permit then add a new redirect record (OnDocFormSave)
- Created new system setting: redirector.on_alias_update (Yes/No)
- Updated readme.txt