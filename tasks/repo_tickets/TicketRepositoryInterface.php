<?php

interface TicketRepositoryInterface
{
    public function load($ticketId);
    public function save($ticket);
    public function update($ticket);
    public function delete($ticket);
}
