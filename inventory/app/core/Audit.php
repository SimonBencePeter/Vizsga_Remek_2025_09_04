<?php

class Audit
{
    
    public static function diff(array $old, array $new, array $ignore = [], array $mask = []): array
    {
        $ignore = array_flip($ignore);
        $mask   = array_flip($mask);

        
        $keys = array_unique(array_merge(array_keys($old), array_keys($new)));
        $changes = [];

        foreach ($keys as $k) {
            if (isset($ignore[$k])) continue;

            $ov = $old[$k] ?? null;
            $nv = $new[$k] ?? null;

            
            $ovN = is_null($ov) ? null : (string)$ov;
            $nvN = is_null($nv) ? null : (string)$nv;

            if ($ovN !== $nvN) {
                if (isset($mask[$k])) {
                    $changes[] = ['field' => $k, 'old' => '[hidden]', 'new' => '[hidden]'];
                } else {
                    $changes[] = ['field' => $k, 'old' => $ov, 'new' => $nv];
                }
            }
        }
        return $changes;
    }
}
