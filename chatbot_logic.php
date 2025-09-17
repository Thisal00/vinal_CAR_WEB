<?php
session_start();

/*
  Vinal Auto Chatbot — Sri Lanka Market (Optimized 2025)
  - POST 'query' for user input (e.g., 1, a1, 100000, book Toyota Axio).
  - Session tracks menu state (no unnecessary variables).
  - 00/99 resets to Main Menu.
  - Salary menu shows affordable vehicles directly.
*/

// Escape output for security
function e($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

// Vehicle catalog (shared for vehicles and salary menus)
$catalog = [
    "a1" => [
        "title" => "Cars — Sedans & City Cars",
        "items" => [
            ["name" => "Toyota Axio 2018", "price" => 8700000, "details" => "Hybrid, 20 km/l, low maintenance, ideal for city."],
            ["name" => "Honda Civic 2019", "price" => 14200000, "details" => "Sporty, reliable, safety features, family-friendly."],
            ["name" => "Nissan Sunny 2020", "price" => 7500000, "details" => "Affordable, spacious, good for daily commute."]
        ]
    ],
    "b1" => [
        "title" => "Hatchbacks",
        "items" => [
            ["name" => "Suzuki Swift 2021", "price" => 6800000, "details" => "Stylish, 22 km/l, compact for urban roads."],
            ["name" => "Hyundai i10 2022", "price" => 6000000, "details" => "Small, low running costs, great for Colombo."],
            ["name" => "Toyota Vitz 2019", "price" => 7200000, "details" => "Hybrid option, reliable, good boot space."]
        ]
    ],
    "c1" => [
        "title" => "SUVs",
        "items" => [
            ["name" => "Toyota RAV4 2020", "price" => 28500000, "details" => "Spacious, hybrid, high clearance, SL roads."],
            ["name" => "Mitsubishi Outlander 2021", "price" => 23000000, "details" => "Plug-in hybrid, comfy for long trips."],
            ["name" => "Honda CR-V 2019", "price" => 25500000, "details" => "Premium interior, safety tech, family use."]
        ]
    ],
    "d1" => [
        "title" => "Jeeps / 4x4",
        "items" => [
            ["name" => "Jeep Wrangler 2021", "price" => 38500000, "details" => "Rugged, off-road king, removable top."],
            ["name" => "Isuzu D-Max 2022", "price" => 21500000, "details" => "4x4 pickup, durable, rough terrain."],
            ["name" => "Toyota Land Cruiser Prado 2020", "price" => 46000000, "details" => "Luxury 4x4, powerful, premium comfort."]
        ]
    ],
    "e1" => [
        "title" => "Buses / Minibuses",
        "items" => [
            ["name" => "Toyota Coaster 2021", "price" => 33000000, "details" => "Reliable, A/C, 20-30 seats, tours."],
            ["name" => "Ashok Leyland Minibus 2020", "price" => 21000000, "details" => "Cost-effective, durable, transport biz."],
            ["name" => "Nissan Civilian 2019", "price" => 29000000, "details" => "Spacious, comfy, long-distance travel."]
        ]
    ]
];

// Check for input
if (!isset($_POST['query'])) {
    echo "❗ No input received.";
    exit;
}

$query = strtolower(trim($_POST['query']));
$normalized = str_replace([' ', ','], '.', $query);

// Reset session on 00/99
if ($normalized === "00" || $normalized === "99") {
    unset($_SESSION['menu']);
    echo "🔙 Back to Main Menu\n\n1️⃣ Vehicles\n2️⃣ Financial\n3️⃣ Add Salary (Estimate Vehicle)\n4️⃣ Contact Us\n5️⃣ Brand New Car Booking\n\nType option (e.g., 1):";
    exit;
}

// Main menu routing
if (!isset($_SESSION['menu'])) {
    switch ($query) {
        case "1":
            $_SESSION['menu'] = "vehicles";
            echo "🚗 Vehicles Menu:\na1️⃣ Cars\nb1️⃣ Hatchbacks\nc1️⃣ SUVs\nd1️⃣ Jeeps / 4x4\ne1️⃣ Buses\n\nType option (e.g., a1) or 00/99 for Main Menu:";
            break;
        case "2":
            $_SESSION['menu'] = "financial";
            echo " Financial Menu:\na2️⃣ Financial Advice\nb2️⃣ Banks & Loan Details\nc2️⃣ Insurance Advice\n\nType option (e.g., a2) or 00/99 for Main Menu:";
            break;
        case "3":
            $_SESSION['menu'] = "add_salary";
            echo "Add Salary (Estimate Vehicle):\nType your monthly salary (LKR, numbers only, e.g., 100000) or 00/99 for Main Menu:";
            break;
        case "4":
            $_SESSION['menu'] = "contact";
            echo "📞 Contact Us:\na4️⃣ Show Contact Details\nb4️⃣ Open Location Map\n\nType option (e.g., a4) or 00/99 for Main Menu:";
            break;
        case "5":
            $_SESSION['menu'] = "brandnew";
            echo " Brand New Car Booking:\na5️⃣ Booking Steps\nb5️⃣ View Available Models\n\nType option (e.g., a5) or 00/99 for Main Menu:";
            break;
        default:
            echo "👋 Welcome to Vinal Auto! Choose:\n1️⃣ Vehicles\n2️⃣ Financial\n3️⃣ Add Salary (Estimate Vehicle)\n4️⃣ Contact Us\n5️⃣ Brand New Car Booking\n\nType option (e.g., 1):";
    }
    exit;
}

// Handle sub-menus
switch ($_SESSION['menu']) {
    case "vehicles":
        if (preg_match('/^book\s+(.+)$/i', $query, $m)) {
            $model = trim($m[1]);
            echo "✅ Booking request for: " . e($model) . "\nProvide: Full name, Contact number, Dealer (e.g., Colombo), Deposit.\nReply within 24 hours. (Simulated)\n\nType option (e.g., a1) or 00/99 for Main Menu:";
        } elseif (isset($catalog[$query])) {
            $block = $catalog[$query];
            echo "🚘 " . e($block['title']) . ":\n";
            foreach ($block['items'] as $it) {
                echo "- " . e($it['name']) . " | LKR " . e(number_format($it['price'])) . " — " . e($it['details']) . "\n";
            }
            echo "\nType 'book {model}' (e.g., book Toyota Axio) or another option (e.g., b1) or 00/99 for Main Menu:";
        } else {
            echo "❌ Invalid option.\nChoose: a1️⃣ Cars, b1️⃣ Hatchbacks, c1️⃣ SUVs, d1️⃣ Jeeps, e1️⃣ Buses\n(00/99 Main Menu)";
        }
        break;

    case "financial":
        if ($query === "a2") {
            echo "Financial Advice (2025):\n- Budget: Car costs <30% monthly income.\n- EMI: ≤40% take-home pay.\n- Down payment: 20-30% reduces interest.\n- Fuel: Hybrids save (fuel ~LKR 400/l).\n- Compare dealers vs. imports.\n\nType b2 (Loans), c2 (Insurance) or 00/99 Main Menu:";
        } elseif ($query === "b2") {
            echo "Loans (2025):\n- Rates: 12-14% p.a.\n- Tenure: 5-8 yrs.\n- Loan: 70-80% vehicle value.\n- Needs: NIC, income proof.\n\nBanks:\n- People's: +94 11 220 6789 (12.5-14%)\n- Sampath: +94 11 230 3040 (~12%)\n- HNB: +94 11 266 4664 (12-13%)\n\nType 'loan {salary} {down_payment}' (e.g., loan 100000 500000) or 00/99 Main Menu:";
        } elseif ($query === "c2") {
            echo " Insurance (2025):\n- Third-party: ~LKR 20,000/yr (mandatory).\n- Comprehensive: 1-3% vehicle value (LKR 60,000-150,000 for 6-10M).\n- Companies: Ceylinco, Allianz, Fairfirst.\n- Tips: Compare quotes, no-claim bonuses.\n\nType a2 (Advice), b2 (Loans) or 00/99 Main Menu:";
        } elseif (preg_match('/^loan\s+(\d+)(?:\s+(\d+))?$/i', $query, $m)) {
            $monthlySalary = (int)$m[1];
            $down = isset($m[2]) ? (int)$m[2] : 0;
            $monthlyLimit = $monthlySalary * 0.4;
            $r = 0.13 / 12; $n = 60;
            $maxLoan = $r > 0 ? $monthlyLimit * (1 - pow(1 + $r, -$n)) / $r : $monthlyLimit * $n;
            $maxLoan = max(0, round($maxLoan)) + $down;
            echo "Loan Estimate (Salary: LKR " . e(number_format($monthlySalary)) . "/mo, Down: LKR " . e(number_format($down)) . "):\n- Safe EMI: LKR " . e(number_format(round($monthlyLimit))) . "\n- Max price (5 yrs @13%): LKR " . e(number_format($maxLoan)) . "\n- Rates vary (12-14%). Contact banks.\n\nType a2, b2, c2 or 00/99 Main Menu:";
        } else {
            echo "❌ Invalid option.\nChoose: a2️⃣ Advice, b2️⃣ Loans, c2️⃣ Insurance\n(00/99 Main Menu)";
        }
        break;

    case "add_salary":
        if (preg_match('/^\d+$/', $query)) {
            $monthly = (int)$query;
            $annual = $monthly * 12;
            $lowBudget = $annual * 1.0;
            $highBudget = $annual * 3.0;
            $loanPrincipal = round($highBudget * 0.8); // Assume 80% loan
            $r = 0.13 / 12; $n = 60;
            $emi = $r > 0 ? $loanPrincipal * $r * pow(1 + $r, $n) / (pow(1 + $r, $n) - 1) : $loanPrincipal / $n;
            
            // Filter affordable vehicles
            $affordable = [];
            foreach ($catalog as $key => $category) {
                foreach ($category['items'] as $item) {
                    if ($item['price'] >= $lowBudget && $item['price'] <= $highBudget) {
                        $affordable[] = "- " . e($item['name']) . " | LKR " . e(number_format($item['price'])) . " — " . e($item['details']);
                    }
                }
            }
            
            echo "💰 Salary Estimate (LKR " . e(number_format($monthly)) . "/mo):\n- Annual: LKR " . e(number_format($annual)) . "\n- Budget: LKR " . e(number_format($lowBudget)) . " - " . e(number_format($highBudget)) . "\n- EMI for LKR " . e(number_format($loanPrincipal)) . " (5 yrs @13%): LKR " . e(number_format(round($emi))) . "\n\nAffordable Vehicles:\n";
            echo $affordable ? implode("\n", $affordable) : "- No vehicles in this budget. Try a higher salary or financing (see b2).";
            echo "\n\nType new salary (e.g., 150000) or 00/99 Main Menu:";
        } else {
            echo "❌ Enter monthly salary (LKR, numbers only, e.g., 100000):\n(00/99 Main Menu)";
        }
        break;

    case "contact":
        if ($query === "a4") {
            echo "📍 Vinal Auto:\nOwner: Mr. A. Silva\nPhone: +94 76 829 1088\nEmail: info@vinalauto.com\nAddress: 123 Car Street, Colombo\n\nType b4 for map or 00/99 Main Menu:";
        } elseif ($query === "b4") {
            $mapUrl = "https://www.google.com/maps/search/?api=1&query=" . urlencode("123 Car Street Colombo Sri Lanka");
            echo "🗺️ Map: " . $mapUrl . "\n\n(Click to open Google Maps)\nType a4 or 00/99 Main Menu:";
        } else {
            echo "❌ Invalid option.\nChoose: a4️⃣ Details, b4️⃣ Map\n(00/99 Main Menu)";
        }
        break;

    case "brandnew":
        if (preg_match('/^book\s+(.+)$/i', $query, $m)) {
            $model = trim($m[1]);
            echo "✅ Booking request for: " . e($model) . "\nProvide: Full name, Contact number, Dealer, Deposit.\nReply within 24 hours. (Simulated)\n\nType a5, b5 or 00/99 Main Menu:";
        } elseif ($query === "a5") {
            echo "🏁 Booking Steps:\n1. Pick model (see b5).\n2. Submit NIC, income proof, 10-20% deposit.\n3. Sign agreement, delivery in 3-6 months.\n4. Pay balance or finance (see b2).\n\nType b5 or 'book {model}' or 00/99 Main Menu:";
        } elseif ($query === "b5") {
            echo "🚘 Brand-New (2025):\n- Nissan Almera 2025 — LKR 14,000,000 (Sedan, efficient).\n- Toyota Hilux 2025 — LKR 25,500,000 (4x4 pickup).\n- Suzuki Wagon R 2025 — LKR 10,500,000 (Hybrid hatch).\n\nType 'book {model}' or a5 or 00/99 Main Menu:";
        } else {
            echo "❌ Invalid option.\nChoose: a5️⃣ Steps, b5️⃣ Models\n(00/99 Main Menu)";
        }
        break;

    default:
        unset($_SESSION['menu']);
        echo "ℹ️ Session reset.\n\n1️⃣ Vehicles\n2️⃣ Financial\n3️⃣ Add Salary\n4️⃣ Contact Us\n5️⃣ Brand New Car Booking\n\nType option (e.g., 1):";
}

?>
