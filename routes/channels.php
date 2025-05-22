<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('liga.{ligaId}', function ($user, $ligaId) {
    return $user->ligas->contains('id', (int)$ligaId);
});
