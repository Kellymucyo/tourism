<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

$pageTitle = "Rwanda Travel Tips & Essentials";
?>

<?php include '../includes/header.php'; ?>

<!-- Travel Tips Header -->
<div class="row mb-4">
    <div class="col-12">
        <h1>Rwanda Travel Tips</h1>
        <p class="lead">Essential information for your visit to Rwanda</p>
    </div>
</div>

<!-- Travel Tips Content -->
<div class="row">
    <div class="col-md-8">
        <!-- Visa Information -->
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title"><i class="fas fa-passport text-success me-2"></i> Visa Information</h2>
                <div class="row">
                    <div class="col-md-6">
                        <h4>Visa on Arrival</h4>
                        <p>Visitors from most countries can obtain a visa upon arrival at Kigali International Airport or land borders.</p>
                        <ul>
                            <li>Cost: $50 USD (single entry, 30 days)</li>
                            <li>Passport must be valid for 6 months</li>
                            <li>Yellow fever vaccination required</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h4>East African Tourist Visa</h4>
                        <p>Allows travel between Rwanda, Kenya, and Uganda for 90 days.</p>
                        <ul>
                            <li>Cost: $100 USD</li>
                            <li>Can be obtained online or on arrival</li>
                            <li>Multiple entries between the 3 countries</li>
                        </ul>
                    </div>
                </div>
                <a href="https://www.migration.gov.rw/visa/" target="_blank" class="btn btn-success mt-2">Official Visa Information</a>
            </div>
        </div>
        
        <!-- Currency & Money -->
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title"><i class="fas fa-money-bill-wave text-success me-2"></i> Currency & Money</h2>
                <div class="row">
                    <div class="col-md-6">
                        <h4>Rwandan Franc (RWF)</h4>
                        <p>The official currency is the Rwandan Franc (RWF).</p>
                        <ul>
                            <li>Current exchange rate: ~1,000 RWF = $1 USD</li>
                            <li>Banknotes: 500, 1000, 2000, 5000, 10000 RWF</li>
                            <li>Coins: 1, 5, 10, 20, 50, 100 RWF</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h4>Payment Methods</h4>
                        <ul>
                            <li>USD widely accepted but change given in RWF</li>
                            <li>Credit cards accepted in major hotels and restaurants</li>
                            <li>ATMs available in cities (Visa/Mastercard)</li>
                            <li>Mobile money (MTN Mobile Money, Airtel Money) very popular</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Health & Safety -->
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title"><i class="fas fa-heartbeat text-success me-2"></i> Health & Safety</h2>
                <div class="row">
                    <div class="col-md-6">
                        <h4>Health Precautions</h4>
                        <ul>
                            <li>Yellow fever vaccination required</li>
                            <li>Malaria prophylaxis recommended</li>
                            <li>Drink bottled or boiled water</li>
                            <li>Pack basic medications and first aid</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h4>Safety Tips</h4>
                        <ul>
                            <li>Rwanda is one of Africa's safest countries</li>
                            <li>Standard precautions against petty theft</li>
                            <li>Emergency number: 112</li>
                            <li>Respect local customs and dress modestly</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Transportation -->
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title"><i class="fas fa-bus text-success me-2"></i> Transportation</h2>
                <div class="row">
                    <div class="col-md-4">
                        <h4>Public Transport</h4>
                        <ul>
                            <li>City buses in Kigali (100-500 RWF)</li>
                            <li>Motorcycle taxis (safe with helmets)</li>
                            <li>Shared minibuses between cities</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h4>Taxis</h4>
                        <ul>
                            <li>Official taxis are white with yellow stripes</li>
                            <li>Use Yego Cab app for metered taxis</li>
                            <li>Negotiate price before long trips</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h4>Car Rental</h4>
                        <ul>
                            <li>International license required</li>
                            <li>Drive on the right side</li>
                            <li>4x4 recommended for rural areas</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Quick Facts -->
        <div class="card mb-4">
            <div class="card-body">
                <h3 class="card-title">Rwanda at a Glance</h3>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-globe-africa me-2 text-success"></i> Capital</span>
                        <span>Kigali</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-language me-2 text-success"></i> Languages</span>
                        <span>Kinyarwanda, English, French, Swahili</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-users me-2 text-success"></i> Population</span>
                        <span>13 million</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-mountain me-2 text-success"></i> Elevation</span>
                        <span>1,000 - 4,500m</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-calendar-alt me-2 text-success"></i> Time Zone</span>
                        <span>CAT (UTC+2)</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-plug me-2 text-success"></i> Electricity</span>
                        <span>220V, Type C & E plugs</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Weather -->
        <div class="card mb-4">
            <div class="card-body">
                <h3 class="card-title"><i class="fas fa-cloud-sun me-2 text-success"></i> Weather</h3>
                <p>Rwanda has a temperate tropical highland climate with two rainy seasons:</p>
                <ul>
                    <li><strong>Long rains:</strong> March - May</li>
                    <li><strong>Short rains:</strong> October - November</li>
                    <li><strong>Dry seasons:</strong> June - September, December - February</li>
                </ul>
                <p>Average temperatures range from 15°C (59°F) to 27°C (81°F) depending on altitude.</p>
            </div>
        </div>
        
        <!-- Emergency Contacts -->
        <div class="card mb-4">
            <div class="card-body">
                <h3 class="card-title"><i class="fas fa-phone-alt me-2 text-success"></i> Emergency Contacts</h3>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>General Emergency</strong><br>
                        112 (free from any phone)
                    </li>
                    <li class="list-group-item">
                        <strong>Police</strong><br>
                        112 or 999
                    </li>
                    <li class="list-group-item">
                        <strong>Medical Emergency</strong><br>
                        912
                    </li>
                    <li class="list-group-item">
                        <strong>Tourist Police</strong><br>
                        +250 788 313 333
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Useful Phrases -->
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><i class="fas fa-comments me-2 text-success"></i> Useful Kinyarwanda Phrases</h3>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Hello</strong><br>
                        Muraho
                    </li>
                    <li class="list-group-item">
                        <strong>Thank you</strong><br>
                        Murakoze
                    </li>
                    <li class="list-group-item">
                        <strong>How much?</strong><br>
                        Ni ikihe giciro?
                    </li>
                    <li class="list-group-item">
                        <strong>I don't understand</strong><br>
                        Sinumva
                    </li>
                    <li class="list-group-item">
                        <strong>Goodbye</strong><br>
                        Murabeho
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>