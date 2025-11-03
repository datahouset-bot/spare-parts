$ledgers = Ledger::withinFY('entry_date')->get();---done
$checkins = RoomCheckin::withinFY('checkin_date')->get();----done
$checkouts = RoomCheckout::withinFY('checkout_date')->get();------done
$foodbills = Foodbill::withinFY('voucher_date')->get();
$kots = Kot::withinFY('voucher_date')->get();
$vouchers = Voucher::withinFY('entry_date')->get();
$roombookings = roombookings::withinFY('checkin_date')->get();
inventories=inventories::withinFY('entry_date')->get();