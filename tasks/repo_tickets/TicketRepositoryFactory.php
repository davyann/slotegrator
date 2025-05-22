<?php

class TicketRepositoryFactory
{
    public static function create($source = 'db'): TicketRepositoryInterface
    {
        return match ($source) {
            'api'   => new ApiTicketRepository(),
            default => new DbTicketRepository(),
        };
    }
}
