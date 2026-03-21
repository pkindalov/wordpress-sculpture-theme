<?php
/**
 * Template Helper Functions
 *
 * @package Sculpture_Theme
 * @since   1.0.0
 */

// Exit if accessed directly
if (!defined("ABSPATH")) {
    exit();
}

//function which return the currently active language set on the page. - bg or en
function get_current_active_language() {
    $default_lang = 'bg';
    return function_exists('pll_current_language') ? mb_strtolower(pll_current_language()) : $default_lang;
}


/**
 * Translate material field
 */
function sculpture_translate_material($material) {
    $material_lowercase = $material ? mb_strtolower($material) : 'brass'; 
    if (get_current_active_language() === 'bg') {
        $translations = array(
            'bronze' => 'Бронз',
            'marble' => 'Мрамор',
            'stone' => 'Камък',
            'wood' => 'Дърво',
            'clay' => 'Глина',
            'metal' => 'Метал',
            'glass' => 'Стъкло',
            'resin' => 'Смола',
            'mixed media' => 'Смесена техника',
            'ceramic' => 'Керамика',
            'brass' => 'Месинг',
        );
        return isset($translations[$material_lowercase]) ? $translations[$material_lowercase] : $material_lowercase;
    }
    return $material;
}


const material_translations = [
                "bg" => [
                    'brass' => 'Месинг',
                    'bronze' => 'Бронз',
                    'marble' => 'Мрамор',
                    'stone' => 'Камък',
                    'wood' => 'Дърво',
                    'clay' => 'Глина',
                    'metal' => 'Метал',
                    'glass' => 'Стъкло',
                    'resin' => 'Смола',
                    'mixed media' => 'Смесена техника',
                    'ceramic' => 'Керамика',
                ],
                "en" => [
                    'месинг' => 'Brass',
                    'бронз' => 'Bronze',
                    'мрамор' => 'Marble',
                    'камък' => 'Stone',
                    'дърво' => 'Wood',
                    'глина' => 'Clay',
                    'метал' => 'Metal',
                    'стъкло' => 'Glass',
                    'смола' => 'Resin',
                    'смесена техника' => 'Mixed media',
                    'керамика' => 'Ceramic',
                ]
];

const availability_translations = [
                "bg" => [
                    'available' => 'Налично',
                    'sold' => 'Продадено',
                    'reserved' => 'Резервирано',
                    'exhibition' => 'На изложба',
                    'commissioned' => 'Поръчано',
                    'collection' => 'Частна колекция',
                ],
                "en" => [
                    'налично' => 'Available',
                    'продадено' => 'Sold',
                    'резервирано' => 'Reserved',
                    'на изложба' => 'On Exhibition',
                    'поръчано' => 'Commissioned',
                    'частна колекция' => 'Private Collection',
                ]
]; 

const product_mode_translations = [
                "bg" => [
                    'featured' => 'На Фокус',
                    'promoted' => 'Промоция',
                    'ends' => 'Свършва'
                ],
                "en" => [
                    'На Фокус' => 'featured',
                    'Промоция' => 'promoted',
                    'Свършва' => 'Ends'
                ]
];

const product_data_translations = [
            "bg" => [
                "year" => "година",
                "materials" => "материали",
                "dimensions" => "размери",
                "price" => "цена",
                "availability" => "наличност"
            ],
            "en" => [
                "година" => "year",
                "материали" => "materials",
                "размери" => "dimensions",
                "цена" => "price",
                "наличност" => "availability"
            ]
];

const common_translations = [
    "bg" => [
        "About This Work" =>    "За Творбата",
        "Sculpture Gallery" => "Галерия Със Скулптури",
        "Explore our collection of original artworks" => "Разгледайте нашата колекция от оригинални произведения на изкуството",
        "sculptures found" => "намерени скулптури",
        "No sculptures found" => "Не са намерени скулптури",
        "Try adjusting your filters to see more results" => "Опитайте да коригирате филтрите си, за да видите повече резултати",
        "Interested in a Commission?" => "Интересувате ли се от изработка по поръчка?",
        "Let's create something unique together. Contact us to discuss your vision" => "Нека създадем нещо уникално заедно. Свържете се с нас, за да обсъдим вашата идея.",
        "Exhibitions" => "Изложби",
        "No exhibitions found." => "Не са намерени изложби.",
        "Original" => "Източник",
        "Publications" => "Публикации",
        "All" => "Всички",
        "Written by me" => "Написани от мен",
        "Written about me" => "Написани за мен",
        "Selected Works" => "Избрани произведения",
        "Discover our latest sculptures" => "Разгледайте най-новите ни скулптури",
        "Special Offers" => "Специални Оферти",
        "Limited time prices on selected original sculptures" => "Промоционални цени за ограничено време на избрани оригинални скулптури",
        "Author" => "Автор",
        "Thank you! Your testimonial has been submitted and is pending review" => "Благодаря! Вашият отзив е изпратен и е в процес на преглед",
        "What Our Clients Say" => "Отзиви от наши клиенти",
        "Your feedback helps us improve and helps others make informed decisions" => "Вашата обратна връзка ни помага да се усъвършенстваме и да помагаме на другите да вземат информирани решения",
        "Your Name" => "Име",
        "Email Address" => "Имейл адрес",
        "Will not be displayed publicly" => "Няма да бъде показано публично",
        "Company / Position" => "Компания / Длъжност",
        "CEO at Company Name" => "Главен изпълнителен директор на компанията",
        "Rating" => "Оценка",
        "Your Testimonial" => "Отзив",
        "Display my rating publicly" => "Покажи оценката ми публично",
        "No publications found" => "Не са намерени публикации",
        "Client Testimonials" => "Отзиви на клиенти",
        "What our clients say about working with us" => "Какво казват нашите клиенти за работата с нас",
        "No testimonials yet. Be the first to share your experience" => "Все още няма отзиви. Бъдете първият, който ще сподели своя опит",
        "About the Artist" => "За скулптора",
        "Contemporary sculptor working with bronze, stone, and mixed media. Creating unique pieces that explore the intersection of form and emotion" => "Съвременен скулптор, работещ с бронз, камък и смесена техника. Създава уникални произведения, които изследват пресечната точка на формата и емоцията",
        "Explore" => "Разгледайте",
        "Get in Touch" => "Свържете се с нас",
        "Pazardzhik, Bulgaria" => "Пазарджик, България",
        "Unique Bronze Sculptures by Dr. Stan" => "Уникални бронзови скулптури от Станимир Куюмджиев",
        "All rights reserved" => "Всички права запазени",
        "Privacy Policy" => "Политика за поверителност",
        "Terms of Use" => "Условия за ползване"
    ] ,
    "en" => [
        "За Творбата" => "About This Work",
        "Галерия Със Скулптури" => "Sculpture Gallery",
        "Разгледайте нашата колекция от оригинални произведения на изкуството" => "Explore our collection of original artworks",
        "намерени скулптури" => "sculptures found",
        "Не са намерени скулптури" => "No sculptures found",
        "Опитайте да коригирате филтрите си, за да видите повече резултати" => "Try adjusting your filters to see more results",
        "Интересувате ли се от изработка по поръчка?" => "Interested in a Commission?",
        "Нека създадем нещо уникално заедно. Свържете се с нас, за да обсъдим вашата идея." => "Let's create something unique together. Contact us to discuss your vision",
        "Изложби" => "Exhibitions",
        "Не са намерени изложби." => "No exhibitions found.",
        "Източник" => "Original",
        "Публикации" => "Publications",
        "Всички" => "All",
        "Написани от мен" => "Written by me",
        "Написани за мен" => "Written about me",
        "Избрани произведения" => "Selected Works",
        "Разгледайте най-новите ни скулптури" => "Discover our latest sculptures",
        "Специални Оферти" => "Special Offers",
        "Промоционални цени за ограничено време на избрани оригинални скулптури" => "Limited time prices on selected original sculptures",
        "Автор" => "Author",
        "Благодаря! Вашият отзив е изпратен и е в процес на преглед" => "Thank you! Your testimonial has been submitted and is pending review",
        "Отзиви от наши клиенти" => "What Our Clients Say",
        "Вашата обратна връзка ни помага да се усъвършенстваме и да помагаме на другите да вземат информирани решения" => "Your feedback helps us improve and helps others make informed decisions",
        "Име" => "Your Name",
        "Имейл адрес" => "Email Address",
        "Няма да бъде показано публично" => "Will not be displayed publicly",
        "Компания / Длъжност" => "Company / Position",
        "Главен изпълнителен директор на компанията" => "CEO at Company Name",
        "Оценка" => "Rating",
        "Отзив" => "Your Testimonial",
        "Покажи оценката ми публично" => "Display my rating publicly",
        "Не са намерени публикации" => "No publications found",
        "Отзиви на клиенти" => "Client Testimonials",
        "Какво казват нашите клиенти за работата с нас" => "What our clients say about working with us",
        "Все още няма отзиви. Бъдете първият, който ще сподели своя опит" => "No testimonials yet. Be the first to share your experience",
        "За скулптора" => "About the Artist",
        "Съвременен скулптор, работещ с бронз, камък и смесена техника. Създава уникални произведения, които изследват пресечната точка на формата и емоцията" => "Contemporary sculptor working with bronze, stone, and mixed media. Creating unique pieces that explore the intersection of form and emotion",
        "Разгледайте" => "Explore",
        "Свържете се с нас" => "Get in Touch",
        "Пазарджик, България" => "Pazardzhik, Bulgaria",
        "Уникални бронзови скулптури от Станимир Куюмджиев" => "Unique Bronze Sculptures by Dr. Stan",
        "Всички права запазени" => "All rights reserved",
        "Политика за поверителност" => "Privacy Policy",
        "Условия за ползване" => "Terms of Use"
    ]
];

const exhibition_translations = [
    "bg" => [
        "Current" => "Актуална",
        "Upcoming" => "Предстояща",
        "Past" => "Минала"
    ],
    "en" => [
        "Актуална" => "Current",
        "Предстояща" => "Upcoming",
        "Минала" => "Past"
    ]
];

const filters_translations = [
    "bg" => [
         "Search..."  => "Търси...",
        "Latest" => "Най-Нови",
        "A-Z" => "А-Я",
        "Newest (by Year)" => "Най-Нови (По година)",
        "Price: Low" => "Цена: Възходяща",
        "Price: High" => "Цена: Нисходяща",
        "Featured" => "На Фокус",
        "On Promotion" => "На Промоция",
        "Advanced Filters" => "Повече Филтри",
        "Availability" => "Наличност",
        "All Sculptures" => "Всички Скулптури",
        "Material" => "Материал",
        "All Materials" => "Всички Материали",
        "Price Range" => "Ценови Диапазон",
        "Year Range" => "Годишен Диапазон"
    ],
    "en" => [
        "Търси..."  => "Search...",
        "Най-Нови" => "Latest",
        "А-Я" => "A-Z",
        "Най-Нови (По година)" => "Newest (by Year)",
        "Цена: Възходяща" => "Price: Low",
        "Цена: Нисходяща" => "Price: High",
        "На Фокус" => "Featured",
        "На Промоция" => "On Promotion",
        "Повече Филтри" => "Advanced Filters",
        "Наличност" => "Availability",
        "Всички Скулптури"=> "All Sculptures",
        "Материал" => "Material",
        "Всички Материали" => "All Materials",
        "Ценови Диапазон" => "Price Range",
        "Годишен Диапазон" => "Year Range"
    ]
];

const buttons = [
    "bg" => [
        "Back To Gallery" => "Към Галерията",
        "Apply Filters" => "Приложи Филтри",
        "Clear All" => "Премахни Филтри",
        "Back to Home" => "Към Начална Страница",
        "Get in Touch" => "Свържете се с нас",
        "Previous" => "Предишна",
        "Next" => "Следваща",
        "Read More" => "Прочети Повече",
        "View All Sculptures" => "Виж всички скулптури",
        "View All Offers" => "Виж всички оферти",
        "View All Exhibitions" => "Виж всички изложби",
        "View All Publications" => "Виж всички публикации",
        "View All Testimonials" => "Виж всички отзиви",
        "Share Your Experience" => "Напишете отзив",
        "Leave a Review" => "Оставете отзив"
    ],
    "en" => [
        "Към Галерията" => "Back To Gallery",
        "Приложи Филтри" => "Apply Filters",
        "Премахни Филтри" => "Clear All",
        "Към Начална Страница" => "Back to Home",
        "Свържете се с нас" => "Get in Touch",
        "Предишна" => "Previous",
        "Следваща" => "Next",
        "Прочети Повече" => "Read More",
        "Виж всички скулптури" => "View All Sculptures",
        "Виж всички оферти" => "View All Offers",
        "Виж всички изложби" => "View All Exhibitions",
        "Виж всички публикации" => "View All Publications",
        "Виж всички отзиви" => "View All Testimonials",
        "Напишете отзив" => "Share Your Experience",
        "Оставете отзив" => "Leave a Review"
    ]
]; 

const errors_translations = [
    "bg" => [
        "Security check failed. Please refresh the page and try again" => "Проверката за сигурност не бе успешна. Моля, обновете страницата и опитайте отново",
        "Name is required" => "Името е задължително",
        "Valid email is required" => "Изисква се валиден имейл адрес",
        "Rating must be between 1 and 5" => "Оценката трябва да е между 1 и 5",
        "Message is required" => "Съобщението е задължително",
        "Failed to submit testimonial. Please try again" => "Изпращането на отзив не бе успешно. Моля, опитайте отново"
    ],
    "en" => [
        "Проверката за сигурност не бе успешна. Моля, обновете страницата и опитайте отново" => "Security check failed. Please refresh the page and try again",
        "Името е задължително" => "Name is required",
        "Изисква се валиден имейл адрес" => "Valid email is required",
        "Оценката трябва да е между 1 и 5" => "Rating must be between 1 and 5",
        "Съобщението е задължително" => "Message is required",
        "Изпращането на отзив не бе успешно. Моля, опитайте отново" => "Failed to submit testimonial. Please try again"
    ]
];

const navigation_menus_translation = [
    "bg" => [
        "Home" => "Начало",
        "Gallery" => "Галерия",
        "About" => "За скулптора",
        "Exhibitions" => "Изложби",
        "Contact" => "Контакт"
    ],
    "en" => [
        "Начало" => "Home",
        "Галерия" => "Gallery",
        "За скулптора" => "About",
        "Изложби" => "Exhibitions",
        "Контакт" => "Contact"
    ]
];         

function translate_on_active_lang($type = "material",  $word = "") { 
    $lang = function_exists('get_current_active_language') ? get_current_active_language() : "bg";
    $translated_word = '';
    switch($type) {
        case 'material':
            $translated_word = isset(material_translations[$lang][mb_strtolower($word)]) ? material_translations[$lang][mb_strtolower($word)] : $word;
        break;
        case 'availability':
            $translated_word = isset(availability_translations[$lang][mb_strtolower($word)]) ? availability_translations[$lang][mb_strtolower($word)] : $word;    
        break;
        case 'product_mode':
            $translated_word = isset(product_mode_translations[$lang][mb_strtolower($word)]) ? product_mode_translations[$lang][mb_strtolower($word)] : $word;    
        break;
        case 'product_data':
            $translated_word = isset(product_data_translations[$lang][mb_strtolower($word)]) ? product_data_translations[$lang][mb_strtolower($word)] : $word;    
        break;
        case 'common':
            $translated_word = isset(common_translations[$lang][mb_strtolower($word)]) ? common_translations[$lang][mb_strtolower($word)] : $word;
        break;
        case "buttons":
            $translated_word = isset(buttons[$lang][mb_strtolower($word)]) ? buttons[$lang][mb_strtolower($word)] : $word;
        break;
        case "navigation":
            $translated_word = isset(navigation_menus_translation[$lang][mb_strtolower($word)]) ? navigation_menus_translation[$lang][mb_strtolower($word)] : $word;
        break;
        case "errors":
            $translated_word = isset(errors_translations[$lang][mb_strtolower($word)]) ? errors_translations[$lang][mb_strtolower($word)] : $word;
        break;
    }

    return $translated_word;
}

const sculptur_email = "koumdjiev@mail.ru";

//helper function to get  translated word
//don't forget to update function if you add more arrays with translations
function get_translated_word($lang = "bg", $dictionnaire_name = "material", $word = "") {
    $translations = [];
    switch($dictionnaire_name) {
        case 'material':
            $translations = material_translations;
            break;
        case 'availability':
                $translations = availability_translations;
                break; 
        case 'product_mode':
                $translations = product_mode_translations;
                break;
        case 'product_data':
                $translations = product_data_translations;
                break;
        case 'common':
                $translations = common_translations;
                break;
        case 'buttons':
                $translations = buttons;
                break;
        case 'navigation':
                $translations = navigation_menus_translation;
                break;          
        case 'errors':
                $translations = errors_translations;
                break;     
    }

    return isset($translations[$lang][mb_strtolower($word)]) ? $translations[$lang][mb_strtolower($word)] : $word;    
}


//temporaly function to show price in lv 
function showPriceInLv($priceNum = 1) {
    if(get_current_active_language() === 'bg') {
        echo "(" . esc_html(number_format($priceNum * 1.9558, 0)  . "лв/lv") . ")";
    }
}


//helper function for translating date on currently active language
function translate_date_current_lang($date = null) {
    // if(!$date) $date = date('d M Y');

    if(get_current_active_language() === 'bg') {
        $date = new DateTime($date);
        $formatter = new IntlDateFormatter(
        'bg_BG', 
        IntlDateFormatter::LONG, // Формат на датата (напр. 2 март 2026 г.)
        IntlDateFormatter::NONE  // Без час
        );
        return $formatter->format($date);
    }
    return $date;
}

/**
 * Get sculpture info field
 *
 * Helper function to safely get ACF field with fallback
 *
 * @param string $field_name ACF field name
 * @param int|null $post_id Post ID (null for current post)
 * @param string $default Default value if field is empty
 * @return mixed Field value or default
 */
function sculpture_get_field($field_name, $post_id = null, $default = "")
{
    if (!function_exists("get_field")) {
        return $default;
    }

    $value = get_field($field_name, $post_id);

    return $value ? $value : $default;
}

/**
 * Display sculpture info item
 *
 * Outputs formatted info item (label + value)
 *
 * @param string $label Display label
 * @param string $field_name ACF field name
 * @param int|null $post_id Post ID
 */
function sculpture_info_item($label, $field_name, $post_id = null)
{
    $value = sculpture_get_field($field_name, $post_id);

    if (!$value) {
        return;
    }
    ?>
    <div class="sculpture-info-item">
        <span class="info-label"><?php echo esc_html($label); ?>:</span>
        <span class="info-value"><?php echo esc_html($value); ?></span>
    </div>
    <?php
}

/**
 * Get sculpture gallery
 *
 * Returns ACF gallery field as array
 *
 * @param int|null $post_id Post ID
 * @return array|false Gallery images or false
 */
function sculpture_get_gallery($post_id = null)
{
    if (!function_exists("get_field")) {
        return false;
    }

    $gallery = get_field("галерия", $post_id);

    return is_array($gallery) && !empty($gallery) ? $gallery : false;
}

/**
 * Display sculpture gallery
 *
 * Outputs formatted gallery HTML
 *
 * @param int|null $post_id Post ID
 */
function sculpture_display_gallery($post_id = null)
{
    $gallery = sculpture_get_gallery($post_id);

    if (!$gallery) {
        return;
    }
    ?>
    <div class="sculpture-gallery">
        <?php foreach ($gallery as $image): ?>
            <div class="gallery-item">
                <img src="<?php echo esc_url($image["url"]); ?>" 
                     alt="<?php echo esc_attr($image["alt"]); ?>"
                     loading="lazy">
            </div>
        <?php endforeach; ?>
    </div>
    <?php
}

/**
 * Check if current post is sculpture type
 *
 * @return bool
 */
function is_sculpture()
{
    return is_singular("sculpture");
}

/**
 * Custom body classes
 *
 * Add custom classes to body tag
 *
 * @param array $classes Existing classes
 * @return array Modified classes
 */
function sculpture_body_classes($classes)
{
    if (is_sculpture()) {
        $classes[] = "sculpture-single";
    }

    return $classes;
}

/**
 * Featured Sculptures Shortcode
 *
 * Display sculpture grid on homepage/any page
 * Usage: [featured_sculptures count="6"]
 *
 * @param array $atts Shortcode attributes
 * @return string HTML output
 */
function sculpture_featured_shortcode($atts)
{
    // Default attributes
    $atts = shortcode_atts(
        [
            "count" => 6,
            "featured_only" => false,
        ],
        $atts,
    );

    // Query args
    $query_args = [
        "post_type" => "sculpture",
        "posts_per_page" => intval($atts["count"]),
        "orderby" => "date",
        "order" => "DESC",
    ];

    // Filter only featured sculptures
    if ($atts["featured_only"] === "true") {
        $query_args["meta_query"] = [
            [
                "key" => "featured",
                "value" => "1",
                "compare" => "=",
            ],
        ];
    }

    $sculptures = new WP_Query($query_args);

    // Start output buffering
    ob_start();
    $selected_works_label =  get_current_active_language() === 'bg' ? common_translations['bg']['Selected Works'] : common_translations['en']['Избрани произведения'];
    $discover_works_label =  get_current_active_language() === 'bg' ? common_translations['bg']['Discover our latest sculptures'] : common_translations['en']['Разгледайте най-новите ни скулптури'];
    $view_all_sculptures_label =  get_current_active_language() === 'bg' ? buttons['bg']['View All Sculptures'] : buttons['en']['Виж всички скулптури'];

    if ($sculptures->have_posts()): ?>
    
    <section class="homepage-sculptures">
        
        <div class="homepage-sculptures-header">
            <h2 class="section-title"><?php echo $selected_works_label; ?></h2>
            <p class="section-subtitle"><?php echo $discover_works_label; ?></p>
        </div>
        
        <div class="sculptures-grid sculptures-grid-homepage">
            
            <?php while ($sculptures->have_posts()):
                $sculptures->the_post();

                // Load card component
                get_template_part("template-parts/sculpture/card");
            endwhile; ?>
            
        </div>
        
        <div class="homepage-sculptures-footer">
            <a href="<?php echo esc_url(
                get_post_type_archive_link("sculpture"),
            ); ?>" class="btn-view-all">
                <?php echo $view_all_sculptures_label; ?> →
            </a>
        </div>
        
    </section>
    
    <?php endif;

    // Reset post data
    wp_reset_postdata();

    // Return output
    return ob_get_clean();
}

/**
 * Check if a sculpture is currently on promotion
 * Checks both on_promotion flag and promotion_ends date
 *
 * @param int $post_id Post ID (optional)
 * @return bool
 */
function sculpture_is_on_promotion($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    // Check if promotion is enabled
    $on_promotion = get_field("on_promotion", $post_id);
    if (!$on_promotion) {
        return false;
    }

    // Check expiry date if set
    $promotion_ends = get_field("promotion_ends", $post_id);
    if ($promotion_ends) {
        $today = date("Ymd");
        if ($today > $promotion_ends) {
            return false;
        }
    }

    return true;
}

/**
 * Get promotion price for a sculpture
 * Priority: manual price → calculated from % → null
 *
 * @param int $post_id Post ID (optional)
 * @return float|null Promotion price or null
 */
function sculpture_get_promotion_price($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    // Not on promotion = no price
    if (!sculpture_is_on_promotion($post_id)) {
        return null;
    }

    $price = get_field("price", $post_id);
    $manual = get_field("promotion_price", $post_id);
    $percentage = get_field("promotion_percentage", $post_id);

    // Priority 1: Manual override
    if ($manual) {
        return round($manual, 2);
    }

    // Priority 2: Calculate from percentage
    if ($price && $percentage) {
        return round($price * (1 - $percentage / 100), 2);
    }

    return null;
}

/**
 * Get promotion percentage for display
 *
 * @param int $post_id Post ID (optional)
 * @return int|null Percentage or null
 */
function sculpture_get_promotion_percentage($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    if (!sculpture_is_on_promotion($post_id)) {
        return null;
    }

    $percentage = get_field("promotion_percentage", $post_id);
    $price = get_field("price", $post_id);
    $manual_price = get_field("promotion_price", $post_id);

    // If manual price - calculate actual percentage
    if ($manual_price && $price) {
        return round((1 - $manual_price / $price) * 100);
    }

    return $percentage ? intval($percentage) : null;
}

/**
 * Promotion Sculptures Shortcode
 * Shows only sculptures currently on promotion
 * Returns empty string if no active promotions (section hidden)
 *
 * Usage: [promo_sculptures count="3"]
 */
function sculpture_promo_shortcode($atts)
{
    $atts = shortcode_atts(
        [
            "count" => 3,
        ],
        $atts,
    );

    $today = date("Ymd");

    $sculptures = new WP_Query([
        "post_type" => "sculpture",
        "posts_per_page" => intval($atts["count"]),
        "meta_query" => [
            "relation" => "AND",
            [
                "key" => "on_promotion",
                "value" => "1",
                "compare" => "=",
            ],
            [
                "relation" => "OR",
                [
                    "key" => "promotion_ends",
                    "compare" => "NOT EXISTS",
                ],
                [
                    "key" => "promotion_ends",
                    "value" => "",
                    "compare" => "=",
                ],
                [
                    "key" => "promotion_ends",
                    "value" => $today,
                    "compare" => ">=",
                ],
            ],
        ],
    ]);

    // Hide section completely if no active promotions
    if (!$sculptures->have_posts()) {
        return "";
    }

    // $special_offers_label
    $special_offers_label =  get_current_active_language() === 'bg' ? common_translations['bg']['Special Offers'] : common_translations['en']['Специални Оферти'];
    $limited_offers_msg_label =  get_current_active_language() === 'bg' ? common_translations['bg']['Limited time prices on selected original sculptures'] : common_translations['en']['Промоционални цени за ограничено време на избрани оригинални скулптури'];
    $view_all_offers_label =  get_current_active_language() === 'bg' ? buttons['bg']['View All Offers'] : buttons['en']['Виж всички оферти'];

    ob_start();
    ?>

    <section class="homepage-promo">

        <div class="homepage-promo-header">
            <h2 class="section-title"><?php echo $special_offers_label; ?></h2>
            <p class="section-subtitle"><?php echo $limited_offers_msg_label;?></p>
        </div>

        <div class="sculptures-grid">
            <?php while ($sculptures->have_posts()):
                $sculptures->the_post();
                get_template_part("template-parts/sculpture/card");
            endwhile; ?>
        </div>

        <div class="homepage-promo-footer">
            <a href="<?php echo esc_url(
                get_post_type_archive_link("sculpture"),
            ); ?>?on_promotion=1" class="btn-view-promo">
               <?php echo $view_all_offers_label; ?>
            </a>
        </div>

    </section>

    <?php
    wp_reset_postdata();
    return ob_get_clean();
}

// ========================================
// EXHIBITIONS HELPER FUNCTIONS
// ========================================

/**
 * Get exhibition status based on dates
 *
 * @param int|null $post_id Exhibition post ID
 * @return string 'current', 'upcoming', or 'past'
 */
function exhibition_get_status($post_id = null)
{
    $start_date = get_field("start_date", $post_id);
    $end_date = get_field("end_date", $post_id);

    if (!$start_date || !$end_date) {
        return "upcoming";
    }

    $today = date("Ymd");

    if ($today >= $start_date && $today <= $end_date) {
        return "current";
    } elseif ($today < $start_date) {
        return "upcoming";
    } else {
        return "past";
    }
}

/**
 * Get exhibition status label
 *
 * @param string $status Status value
 * @return string Translated label
 */
function exhibition_get_status_label($status)
{
    $current_label =  get_current_active_language() === 'bg' ? exhibition_translations['bg']['Current'] : exhibition_translations['en']['Актуална'];
    $upcoming_label =  get_current_active_language() === 'bg' ? exhibition_translations['bg']['Upcoming'] : exhibition_translations['en']['Предстояща'];
    $past_label =  get_current_active_language() === 'bg' ? exhibition_translations['bg']['Past'] : exhibition_translations['en']['Минала'];

    $labels = [
        "current" => __($current_label, "sculpture-theme"),
        "upcoming" => __($upcoming_label, "sculpture-theme"),
        "past" => __($past_label, "sculpture-theme"),
    ];

    return isset($labels[$status]) ? $labels[$status] : "";
}

/**
 * Get formatted date range for exhibition
 *
 * @param int|null $post_id Exhibition post ID
 * @return string Formatted date range
 */
function exhibition_get_date_range($post_id = null)
{
    $start_date = get_field("start_date", $post_id);
    $end_date = get_field("end_date", $post_id);

    if (!$start_date || !$end_date) {
        return "";
    }

    // Convert from Ymd to readable format
    $start = DateTime::createFromFormat("Ymd", $start_date);
    $end = DateTime::createFromFormat("Ymd", $end_date);

    if (!$start || !$end) {
        return "";
    }

    // Format: "15 Jan - 28 Feb 2025"
    if ($start->format("Y") === $end->format("Y")) {
        if ($start->format("m") === $end->format("m")) {
            // Same month: "15-28 Jan 2025"
            return $start->format("j") . "–" . $end->format("j M Y");
        } else {
            // Different months, same year: "15 Jan - 28 Feb 2025"
            return $start->format("j M") . " – " . $end->format("j M Y");
        }
    } else {
        // Different years: "15 Jan 2025 - 28 Feb 2026"
        return $start->format("j M Y") . " – " . $end->format("j M Y");
    }
}

/**
 * Check if exhibition is currently active
 *
 * @param int|null $post_id Exhibition post ID
 * @return bool
 */
function exhibition_is_current($post_id = null)
{
    return exhibition_get_status($post_id) === "current";
}

/**
 * Get exhibitions grouped by status
 *
 * @param int $posts_per_status Posts per status group (-1 for all)
 * @return array Array with 'current', 'upcoming', 'past' keys
 */
function exhibition_get_grouped_by_status($posts_per_status = -1)
{
    $args = [
        "post_type" => "exhibition",
        "posts_per_page" => -1,
        "post_status" => "publish",
        "meta_key" => "start_date",
        "orderby" => "meta_value",
        "order" => "ASC",
    ];

    $exhibitions = get_posts($args);

    $grouped = [
        "current" => [],
        "upcoming" => [],
        "past" => [],
    ];

    foreach ($exhibitions as $exhibition) {
        $status = exhibition_get_status($exhibition->ID);
        $grouped[$status][] = $exhibition;
    }

    return $grouped;
}

// ========================================
// EXHIBITIONS SHORTCODE FOR HOMEPAGE
// ========================================

/**
 * Exhibitions Timeline Shortcode
 *
 * Display recent exhibitions on homepage
 * Usage: [exhibitions_timeline count="3"]
 *
 * @param array $atts Shortcode attributes
 * @return string HTML output
 */
/**
 * Exhibitions Timeline Shortcode
 *
 * Display recent exhibitions on homepage
 * Usage: [exhibitions_timeline count="4"]
 *
 * @param array $atts Shortcode attributes
 * @return string HTML output
 */
function sculpture_exhibitions_timeline_shortcode($atts)
{
    $atts = shortcode_atts(
        [
            "count" => 4,
        ],
        $atts,
        "exhibitions_timeline",
    );

    // Get ALL exhibitions
    $all_args = [
        "post_type" => "exhibition",
        "posts_per_page" => -1,
        "post_status" => "publish",
    ];

    $all_query = new WP_Query($all_args);

    // Sort by status
    $grouped = [
        "current" => [],
        "upcoming" => [],
        "past" => [],
    ];

    if ($all_query->have_posts()) {
        while ($all_query->have_posts()) {
            $all_query->the_post();
            $status = exhibition_get_status(get_the_ID());
            $start_date = get_field("start_date", get_the_ID());

            $grouped[$status][] = [
                "post" => get_post(),
                "start_date" => $start_date,
            ];
        }
        wp_reset_postdata();
    }

    // Sort each group
    usort($grouped["current"], function ($a, $b) {
        return strcmp($b["start_date"], $a["start_date"]);
    });

    usort($grouped["past"], function ($a, $b) {
        return strcmp($b["start_date"], $a["start_date"]);
    });

    usort($grouped["upcoming"], function ($a, $b) {
        return strcmp($a["start_date"], $b["start_date"]);
    });

    // Merge: Current → Upcoming → Past
    $sorted = [];
    foreach ($grouped["current"] as $item) {
        $sorted[] = $item["post"];
    }
    foreach ($grouped["upcoming"] as $item) {
        $sorted[] = $item["post"];
    }
    foreach ($grouped["past"] as $item) {
        $sorted[] = $item["post"];
    }

    // Limit to count
    $limited = array_slice($sorted, 0, intval($atts["count"]));

    if (empty($limited)) {
        return "";
    }

    // Output
    ob_start();

    global $post;
     $exhibitions_title =  get_current_active_language() === 'bg' ? common_translations['bg']['Exhibitions'] : common_translations['en']['Изложби'];
     $view_all_exhibitions_btn_label = get_current_active_language() === 'bg' ? buttons['bg']['View All Exhibitions'] : buttons['en']['Виж всички изложби'];
    ?>
    
    <div class="homepage-exhibitions-section">
        <div class="section-header">
            <h2 class="section-title"><?php echo $exhibitions_title; ?></h2>
            <a href="<?php echo get_post_type_archive_link(
                "exhibition",
            ); ?>" class="view-all-link">
                <?php echo $view_all_exhibitions_btn_label; ?> →
            </a>
        </div>
        
        <div class="exhibition-timeline-list homepage-timeline">
            <?php
            $counter = 0;

            foreach ($limited as $post):
                setup_postdata($post);
                $counter++;
                $side_class =
                    $counter % 2 === 1 ? "timeline-left" : "timeline-right";
                set_query_var("timeline_side", $side_class);
                get_template_part("template-parts/exhibition/timeline-item");
            endforeach;

            wp_reset_postdata();
            ?>
        </div>
        
        <div class="section-footer">
            <a href="<?php echo get_post_type_archive_link(
                "exhibition",
            ); ?>" class="view-all-button">
                <?php echo $view_all_exhibitions_btn_label; ?>
            </a>
        </div>
    </div>
    
    <?php return ob_get_clean();
}

// ========================================
// PUBLICATIONS HELPER FUNCTIONS
// ========================================

/**
 * Get publication type label
 * 
 * @param string $type Type value ('by_me' or 'about_me')
 * @return string Label
 */
function publication_get_type_label($type) {
    $written_by_me_label = get_current_active_language() === 'bg' ? common_translations['bg']['Written by me'] : common_translations['en']['Написани от мен'];
    $written_about_me_label = get_current_active_language() === 'bg' ? common_translations['bg']['Written about me'] : common_translations['en']['Написани за мен'];
    $labels = array(
        'by_me'    => __($written_by_me_label, 'sculpture-theme'),
        'about_me' => __($written_about_me_label, 'sculpture-theme'),
    );
    
    return isset($labels[$type]) ? $labels[$type] : '';
}

/**
 * Get formatted publication date
 * 
 * @param int|null $post_id Post ID
 * @return string Formatted date
 */
function publication_get_date($post_id = null) {
    $date = get_field('publication_date', $post_id);
    
    if (!$date) {
        return '';
    }
    
    // Convert from Ymd to readable format
    $date_obj = DateTime::createFromFormat('Ymd', $date);
    
    if (!$date_obj) {
        return '';
    }
    
    return $date_obj->format('d.m.Y');
}

/**
 * Get publication meta string
 * 
 * @param int|null $post_id Post ID
 * @return string Meta string (Publication, Date, Author if exists)
 */
function publication_get_meta($post_id = null) {
    $publication = get_field('publication', $post_id);
    $date = publication_get_date($post_id);
    $author = get_field('author', $post_id);
    $author_label = get_current_active_language() === 'bg' ? common_translations['bg']['Author'] : common_translations['en']['Автор'];
    
    $meta_parts = array();
    
    if ($publication) {
        $meta_parts[] = $publication;
    }
    
    if ($date) {
        $meta_parts[] = $date;
    }
    
    if ($author) {
        $meta_parts[] = __($author_label . ':', 'sculpture-theme') . ' ' . $author;
    }
    
    return implode(' • ', $meta_parts);
}


/**
 * Publications Shortcode
 * 
 * Display recent publications on homepage (grouped by type)
 * Usage: [publications_showcase by_me="3" about_me="3"]
 * 
 * @param array $atts Shortcode attributes
 * @return string HTML output
 */
function sculpture_publications_showcase_shortcode($atts) {
    
    $atts = shortcode_atts(array(
        'by_me'    => 3,
        'about_me' => 3,
    ), $atts, 'publications_showcase');
    
    // Get "By Me" publications
    $by_me_args = array(
        'post_type'      => 'publication',
        'posts_per_page' => intval($atts['by_me']),
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'meta_query'     => array(
            array(
                'key'     => 'article_type',
                'value'   => 'by_me',
                'compare' => '='
            )
        )
    );
    
    $by_me_posts = new WP_Query($by_me_args);
    
    // Get "About Me" publications
    $about_me_args = array(
        'post_type'      => 'publication',
        'posts_per_page' => intval($atts['about_me']),
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'meta_query'     => array(
            array(
                'key'     => 'article_type',
                'value'   => 'about_me',
                'compare' => '='
            )
        )
    );
    
    $about_me_posts = new WP_Query($about_me_args);
    
    // Check if we have any posts
    if (!$by_me_posts->have_posts() && !$about_me_posts->have_posts()) {
        return '';
    }
    
    // Output
    ob_start();

    $publications_label = get_current_active_language() === 'bg' ? common_translations['bg']['Publications'] : common_translations['en']['Публикации']; 
    $view_all_publications_btn = get_current_active_language() === 'bg' ? buttons['bg']['View All Publications'] : buttons['en']['Виж всички публикации'];

    ?>
    
    <div class="homepage-publications-section">
        <div class="section-header">
            <h2 class="section-title"><?php echo $publications_label; ?></h2>
            <a href="<?php echo get_post_type_archive_link('publication'); ?>" class="view-all-link">
                <?php echo $view_all_publications_btn; ?> →
            </a>
        </div>
        
        <?php if ($by_me_posts->have_posts()): ?>
        <!-- Written by Me Section -->
        <div class="publication-group">
            <!-- <h3 class="group-title">Written by me</h3> -->
            <div class="publications-grid homepage-publications-grid">
                <?php 
                while ($by_me_posts->have_posts()):
                    $by_me_posts->the_post();
                    get_template_part('template-parts/publication/card');
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if ($about_me_posts->have_posts()): ?>
        <!-- Written about Me Section -->
        <div class="publication-group">
            <!-- <h3 class="group-title">Written about me</h3> -->
            <div class="publications-grid homepage-publications-grid">
                <?php 
                while ($about_me_posts->have_posts()):
                    $about_me_posts->the_post();
                    get_template_part('template-parts/publication/card');
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="section-footer">
            <a href="<?php echo get_post_type_archive_link('publication'); ?>" class="view-all-button">
                <?php echo $view_all_publications_btn; ?>
            </a>
        </div>
    </div>
    
    <?php
    return ob_get_clean();
}


// ========================================
// TESTIMONIALS HELPER FUNCTIONS
// ========================================

/**
 * Get star rating HTML
 * 
 * @param int $rating Rating value (1-5)
 * @return string HTML
 */
function testimonial_get_stars($rating) {
    $output = '<div class="testimonial-stars">';
    
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $rating) {
            // Filled star
            $output .= '<svg class="star filled" width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 1l2.5 6.5L19 8l-5 4.5L15.5 19 10 15l-5.5 4L6 12.5 1 8l6.5-.5z"/>
            </svg>';
        } else {
            // Empty star
            $output .= '<svg class="star empty" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                <path d="M10 1l2.5 6.5L19 8l-5 4.5L15.5 19 10 15l-5.5 4L6 12.5 1 8l6.5-.5z" stroke-width="1.5"/>
            </svg>';
        }
    }
    
    $output .= '</div>';
    return $output;
}

/**
 * Get testimonial meta info
 * 
 * @param int|null $post_id Post ID
 * @return string HTML
 */
function testimonial_get_meta($post_id = null) {
    $name = get_field('client_name', $post_id);
    $company = get_field('client_company', $post_id);
    
    if (!$name) {
        $name = get_the_title($post_id);
    }
    
    $output = '<div class="testimonial-author">';
    $output .= '<span class="author-name">' . esc_html($name) . '</span>';
    
    if ($company) {
        $output .= '<span class="author-company">' . esc_html($company) . '</span>';
    }
    
    $output .= '</div>';
    
    return $output;
}

// ========================================
// TESTIMONIAL FORM SUBMISSION
// ========================================

/**
 * Handle testimonial form submission via AJAX
 */
function sculpture_handle_testimonial_submission() {
    // Verify nonce
    $security_check_err_label = get_current_active_language() === 'bg' ? errors_translations['bg']['Security check failed. Please refresh the page and try again'] : errors_translations['en']['Проверката за сигурност не бе успешна. Моля, обновете страницата и опитайте отново']; 

    if (!isset($_POST['testimonial_nonce']) || !wp_verify_nonce($_POST['testimonial_nonce'], 'submit_testimonial')) {
        wp_send_json_error(array(
            'message' => __($security_check_err_label, 'sculpture-theme')
        ));
    }
    
    // Sanitize and validate inputs
    $client_name = sanitize_text_field($_POST['client_name']);
    $client_email = sanitize_email($_POST['client_email']);
    $client_company = sanitize_text_field($_POST['client_company']);
    $rating = intval($_POST['rating']);
    $message = sanitize_textarea_field($_POST['message']);
    $show_rating = isset($_POST['show_rating']) ? 1 : 0;

    $name_err_label = get_current_active_language() === 'bg' ? errors_translations['bg']['Name is required'] : errors_translations['en']['Името е задължително']; 
    $email_err_label = get_current_active_language() === 'bg' ? errors_translations['bg']['Valid email is required'] : errors_translations['en']['Изисква се валиден имейл адрес']; 
    $rating_err_label = get_current_active_language() === 'bg' ? errors_translations['bg']['Rating must be between 1 and 5'] : errors_translations['en']['Оценката трябва да е между 1 и 5']; 
    $message_err_label = get_current_active_language() === 'bg' ? errors_translations['bg']['Message is required'] : errors_translations['en']['Съобщението е задължително']; 
    $fail_send_testimonial_err_label = get_current_active_language() === 'bg' ? errors_translations['bg']['Failed to submit testimonial. Please try again'] : errors_translations['en']['Изпращането на отзив не бе успешно. Моля, опитайте отново']; 
    $testimonial_send_success_label =  get_current_active_language() === 'bg' ? common_translations['bg']['Thank you! Your testimonial has been submitted and is pending review'] : common_translations['en']['Благодаря! Вашият отзив е изпратен и е в процес на преглед']; 
    
    // Validation
    $errors = array();
    
    if (empty($client_name)) {
        $errors[] = __($name_err_label, 'sculpture-theme');
    }
    
    if (empty($client_email) || !is_email($client_email)) {
        $errors[] = __($email_err_label, 'sculpture-theme');
    }
    
    if ($rating < 1 || $rating > 5) {
        $errors[] = __($rating_err_label, 'sculpture-theme');
    }
    
    if (empty($message)) {
        $errors[] = __($message_err_label, 'sculpture-theme');
    }
    
    if (!empty($errors)) {
        wp_send_json_error(array(
            'message' => implode(' ', $errors)
        ));
    }
    
    // Create testimonial post
    $post_data = array(
        'post_title'   => $client_name,
        'post_content' => $message,
        'post_status'  => 'pending', // Pending review
        'post_type'    => 'testimonial',
        'post_author'  => 1, // Admin user
    );
    
    $post_id = wp_insert_post($post_data);
    
    if (is_wp_error($post_id)) {
        wp_send_json_error(array(
            'message' => __($fail_send_testimonial_err_label, 'sculpture-theme')
        ));
    }
    
    // Save ACF fields
    update_field('client_name', $client_name, $post_id);
    update_field('client_email', $client_email, $post_id);
    update_field('client_company', $client_company, $post_id);
    update_field('rating', $rating, $post_id);
    update_field('show_rating', $show_rating, $post_id);
    update_field('featured', 0, $post_id);
    
    // Send email notification to admin
    $admin_email = get_option('admin_email');
    $subject = sprintf(__('[%s] New Testimonial Pending Review', 'sculpture-theme'), get_bloginfo('name'));
    
    $email_message = sprintf(
        __("A new testimonial has been submitted and is pending your review.\n\nName: %s\nEmail: %s\nCompany: %s\nRating: %d/5\n\nMessage:\n%s\n\nReview it here: %s", 'sculpture-theme'),
        $client_name,
        $client_email,
        $client_company ? $client_company : 'N/A',
        $rating,
        $message,
        admin_url('post.php?post=' . $post_id . '&action=edit')
    );
    
    wp_mail($admin_email, $subject, $email_message);
    
    // Success response
    wp_send_json_success(array(
        'message' => __($testimonial_send_success_label, 'sculpture-theme')
    ));
}

/**
 * Add notification badge to Testimonials menu for pending reviews
 */
function sculpture_testimonial_menu_badge() {
    global $menu;
    
    // Count pending testimonials
    $pending_count = wp_count_posts('testimonial')->pending;
    
    if ($pending_count > 0) {
        // Find the testimonials menu item
        foreach ($menu as $key => $item) {
            if ($item[2] === 'edit.php?post_type=testimonial') {
                // Add count badge
                $menu[$key][0] .= ' <span class="awaiting-mod count-' . $pending_count . '"><span class="pending-count">' . number_format_i18n($pending_count) . '</span></span>';
                break;
            }
        }
    }
}


// ========================================
// TESTIMONIALS SLIDER SHORTCODE FOR HOMEPAGE
// ========================================

/**
 * Testimonials Slider Shortcode
 * 
 * Display testimonials in a slider on homepage
 * Usage: [testimonials_slider count="6"]
 * 
 * @param array $atts Shortcode attributes
 * @return string HTML output
 */
function sculpture_testimonials_slider_shortcode($atts) {
    
    $atts = shortcode_atts(array(
        'count' => 6,
    ), $atts, 'testimonials_slider');
    
    // Get published testimonials
    $args = array(
        'post_type'      => 'testimonial',
        'posts_per_page' => intval($atts['count']),
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    
    $testimonials = new WP_Query($args);
    
    if (!$testimonials->have_posts()) {
        return '';
    }

     $what_clients_say_label =  get_current_active_language() === 'bg' ? common_translations['bg']['What Our Clients Say'] : common_translations['en']['Отзиви от наши клиенти']; 
     $view_all_testimonials_btn_label =  get_current_active_language() === 'bg' ? buttons['bg']['View All Testimonials'] : buttons['en']['Виж всички отзиви']; 
     $write_testimonial_btn_label =  get_current_active_language() === 'bg' ? buttons['bg']['Share Your Experience'] : buttons['en']['Напишете отзив']; 
    
    // Output
    ob_start();
    ?>
    
    <div class="homepage-testimonials-section">
        <div class="section-header">
            <h2 class="section-title"><?php echo $what_clients_say_label; ?></h2>
            <a href="<?php echo get_post_type_archive_link('testimonial'); ?>" class="view-all-link">
                <?php echo $view_all_testimonials_btn_label; ?> →
            </a>
        </div>
        
        <div class="testimonials-slider-container">
            
            <!-- Slider -->
            <div class="testimonials-slider" id="testimonials-slider">
                <div class="slider-track">
                    <?php 
                    while ($testimonials->have_posts()):
                        $testimonials->the_post();
                        get_template_part('template-parts/testimonial/card');
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>

            <div class="slider-navigation">
                <button type="button" class="slider-btn prev" id="slider-prev">‹</button>
                <div class="slider-dots" id="slider-dots"></div>
                <button type="button" class="slider-btn next" id="slider-next">›</button>
            </div>
            
        
        <div class="section-footer">
            <button class="testimonial-trigger">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 1l2.5 6.5L19 8l-5 4.5L15.5 19 10 15l-5.5 4L6 12.5 1 8l6.5-.5z"/>
                </svg>
                <?php echo $write_testimonial_btn_label; ?>
            </button>
            <a href="<?php echo get_post_type_archive_link('testimonial'); ?>" class="view-all-button">
                <?php echo $view_all_testimonials_btn_label; ?>
            </a>
        </div>
    </div>
    
    <?php
    return ob_get_clean();
}


add_shortcode("promo_sculptures", "sculpture_promo_shortcode");

add_filter("body_class", "sculpture_body_classes");
add_shortcode("featured_sculptures", "sculpture_featured_shortcode");
add_shortcode(
    "exhibitions_timeline",
    "sculpture_exhibitions_timeline_shortcode",
);
add_shortcode('publications_showcase', 'sculpture_publications_showcase_shortcode');
add_shortcode('testimonials_slider', 'sculpture_testimonials_slider_shortcode');

add_action('wp_ajax_submit_testimonial', 'sculpture_handle_testimonial_submission');
add_action('wp_ajax_nopriv_submit_testimonial', 'sculpture_handle_testimonial_submission');
add_action('admin_menu', 'sculpture_testimonial_menu_badge', 999);