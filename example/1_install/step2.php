<?php
assert(isset($lockData));

/* === STEP-2 ココから === */
foreach (['packages', 'packages-dev'] as $key) {
    foreach ($lockData[$key] as $package) {
        processInstallPackage($package);
    }
}
/* === STEP-2 ココまで === */
