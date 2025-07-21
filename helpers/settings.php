<?php
function getSiteSettings($db)
{
    $stmt = $db->prepare("SELECT id, site_name, maintenance_mode, contact_number, address, logo_besar, logo_kecil, updated_at FROM settings LIMIT 1");
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
