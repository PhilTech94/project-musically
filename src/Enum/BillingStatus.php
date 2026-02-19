<?php

namespace App\Enum;

enum BillingStatus: string
{
    case DRAFT      = 'draft';       // Brouillon
    case QUOTE      = 'quote';       // Devis envoyé
    case PENDING    = 'pending';     // En attente de paiement
    case ACCEPTED   = 'accepted';    // Paiement accepté
    case REFUSED    = 'refused';     // Paiement refusé
    case CANCELLED  = 'cancelled';   // Annulé
    case REFUNDED   = 'refunded';    // Remboursé
}
