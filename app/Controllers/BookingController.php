<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\BookingModel;

class BookingController extends Controller
{
    public function handleBooking(array $bookingInformations)
    {
        if (!isset($bookingInformations["date"]) || !isset($bookingInformations["loggedUser"]) || !isset($bookingInformations["bookedUser"])) {
            echo $this->jsonFailureReponse("Informations manquantes");
            return;
        }

        $bookingModel = new BookingModel();

        if ($bookingModel->bookAppointment($bookingInformations)) {
            echo $this->jsonSuccessReponse($bookingInformations);
        };
    }
}
