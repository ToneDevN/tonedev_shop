<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        // ============================================================
        // หมวดหมู่สินค้า
        // ============================================================
        $categoryData = [
            ['name' => 'สินค้าผู้ชาย',            'slug' => 'men'],
            ['name' => 'เสื้อผ้าสตรี',             'slug' => 'women'],
            ['name' => 'เสื้อผ้าเด็ก',             'slug' => 'children'],
            ['name' => 'สัตว์เลี้ยง',              'slug' => 'pets'],
            ['name' => 'คอมพิวเตอร์',              'slug' => 'computers'],
            ['name' => 'โทรศัพท์มือถือ',           'slug' => 'mobile-phones'],
            ['name' => 'บ้านและสวน',               'slug' => 'home-garden'],
            ['name' => 'อุปกรณ์อิเล็กทรอนิกส์',   'slug' => 'electronics'],
        ];

        foreach ($categoryData as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], ['name' => $cat['name']]);
        }

        $cats = Category::whereIn('slug', array_column($categoryData, 'slug'))
            ->get()
            ->keyBy('slug');

        // ============================================================
        // ข้อมูลสินค้าแยกตามหมวดหมู่
        // ============================================================
        $products = [

            // ── สินค้าผู้ชาย ──────────────────────────────────────
            [
                'category' => 'men',
                'name'  => 'เสื้อเชิ้ตลินิน คอปก สีฟ้าอ่อน',
                'slug'  => 'linen-shirt-light-blue',
                'desc'  => 'เสื้อเชิ้ตลินินคุณภาพสูง ระบายอากาศดี เหมาะสำหรับสวมใส่ในชีวิตประจำวันหรือออกงาน',
                'price' => 890,
                'stock' => 50,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'รายละเอียดสินค้า'],
                    ['type' => 'text',      'data' => 'วัสดุ: ลินิน 100% | ไซส์: S, M, L, XL, XXL'],
                    ['type' => 'paragraph', 'data' => 'ตัดเย็บด้วยผ้าลินินชั้นดี นุ่มสบาย ระบายอากาศได้ดีเยี่ยม เหมาะสำหรับสภาพอากาศร้อน'],
                ],
                'images' => [10, 11, 12],
            ],
            [
                'category' => 'men',
                'name'  => 'กางเกงชิโนขายาว สีกากี ทรงตรง',
                'slug'  => 'chino-pants-khaki',
                'desc'  => 'กางเกงชิโนทรงตรง ผ้าหนาพอดี ใส่ทำงานหรือสบายๆ ได้ทุกโอกาส',
                'price' => 1290,
                'stock' => 35,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'รายละเอียดสินค้า'],
                    ['type' => 'text',      'data' => 'วัสดุ: Cotton 98% Spandex 2% | เอว: 28–38 นิ้ว'],
                    ['type' => 'paragraph', 'data' => 'กางเกงทรง Slim Straight ทันสมัย ใส่ได้ทั้งแบบ casual และ smart casual'],
                ],
                'images' => [20, 21, 22],
            ],
            [
                'category' => 'men',
                'name'  => 'รองเท้า Sneaker หนังแท้ สีขาว',
                'slug'  => 'leather-sneaker-white-men',
                'desc'  => 'รองเท้าผ้าใบหนังแท้ ดีไซน์เรียบ แมตช์ได้กับทุกชุด',
                'price' => 2490,
                'stock' => 20,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'รายละเอียดสินค้า'],
                    ['type' => 'text',      'data' => 'วัสดุ: หนังแท้ | ไซส์: 39–45'],
                    ['type' => 'paragraph', 'data' => 'พื้นรองเท้ายาง EVA นุ่มกระชับ เหมาะสำหรับสวมใส่ทั้งวัน'],
                ],
                'images' => [30, 31, 32],
            ],
            [
                'category' => 'men',
                'name'  => 'นาฬิกาข้อมือ สายหนัง ระบบอนาล็อก',
                'slug'  => 'analog-watch-leather-strap',
                'desc'  => 'นาฬิกาข้อมือดีไซน์คลาสสิก สายหนังแท้ หน้าปัดกลม',
                'price' => 3990,
                'stock' => 15,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'รายละเอียดสินค้า'],
                    ['type' => 'text',      'data' => 'กันน้ำ: 30m | ขนาดหน้าปัด: 42mm | สาย: หนังแท้สีน้ำตาล'],
                    ['type' => 'paragraph', 'data' => 'กลไกควอตซ์ญี่ปุ่น มาพร้อมกล่องของขวัญสุดหรู'],
                ],
                'images' => [40, 41, 42],
            ],

            // ── เสื้อผ้าสตรี ──────────────────────────────────────
            [
                'category' => 'women',
                'name'  => 'เดรสแม็กซี่ พิมพ์ดอก แขนกุด',
                'slug'  => 'floral-maxi-dress',
                'desc'  => 'เดรสยาวพิมพ์ลายดอกไม้ ผ้าชีฟองเบาสบาย สวมใส่ออกงานหรือท่องเที่ยว',
                'price' => 1490,
                'stock' => 40,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'รายละเอียดสินค้า'],
                    ['type' => 'text',      'data' => 'วัสดุ: ชีฟอง 100% | ไซส์: XS, S, M, L, XL'],
                    ['type' => 'paragraph', 'data' => 'ความยาวเดรส 130 ซม. ผ้าซับใน มีซิปด้านหลัง เหมาะสำหรับงานกลางวัน'],
                ],
                'images' => [50, 51, 52],
            ],
            [
                'category' => 'women',
                'name'  => 'กระเป๋าหิ้ว Tote หนัง PU สีดำ',
                'slug'  => 'pu-leather-tote-bag-black',
                'desc'  => 'กระเป๋าหิ้วทรง Tote หนัง PU คุณภาพสูง ใส่ของได้เยอะ',
                'price' => 1890,
                'stock' => 25,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'รายละเอียดสินค้า'],
                    ['type' => 'text',      'data' => 'ขนาด: 35 x 30 x 12 ซม. | วัสดุ: หนัง PU | มีช่องซิปด้านใน 2 ช่อง'],
                    ['type' => 'paragraph', 'data' => 'ทนทาน ทำความสะอาดง่าย มาพร้อมสายสะพายถอดได้'],
                ],
                'images' => [60, 61, 62],
            ],
            [
                'category' => 'women',
                'name'  => 'รองเท้าส้นสูง หัวแหลม สีครีม',
                'slug'  => 'pointed-toe-heels-cream',
                'desc'  => 'รองเท้าส้นสูงดีไซน์เรียบหรู เหมาะสำหรับออกงานหรือสวมใส่ในออฟฟิศ',
                'price' => 1790,
                'stock' => 18,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'รายละเอียดสินค้า'],
                    ['type' => 'text',      'data' => 'ส้นสูง: 8 ซม. | ไซส์: 36–41 | วัสดุ: หนัง PU'],
                    ['type' => 'paragraph', 'data' => 'แผ่นรองในนุ่มพิเศษ ลดแรงกดที่ฝ่าเท้า เหมาะสำหรับใส่ทั้งวัน'],
                ],
                'images' => [70, 71, 72],
            ],
            [
                'category' => 'women',
                'name'  => 'ชุดเซ็ต เสื้อ + กางเกงขายาว สีชมพู',
                'slug'  => 'co-ord-set-pink-top-pants',
                'desc'  => 'ชุดเซ็ตพร้อมเสื้อและกางเกง ผ้านิ่ม สวมใส่ได้ทั้งแยกและแมตช์กัน',
                'price' => 1190,
                'stock' => 30,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'รายละเอียดสินค้า'],
                    ['type' => 'text',      'data' => 'วัสดุ: Cotton ผสม Spandex | ไซส์: S, M, L, XL'],
                    ['type' => 'paragraph', 'data' => 'ชุดที่ตัดมาเซ็ตคู่กัน แมตช์อัตโนมัติ สวยง่ายไม่ต้องคิดมาก'],
                ],
                'images' => [80, 81, 82],
            ],

            // ── เสื้อผ้าเด็ก ──────────────────────────────────────
            [
                'category' => 'children',
                'name'  => 'ชุดนอนเด็ก ลาย Dinosaur แบบซิป',
                'slug'  => 'kids-dinosaur-zip-pajamas',
                'desc'  => 'ชุดนอนเด็กผ้านุ่มพิเศษ ลายไดโนเสาร์น่ารัก ปิดซิปง่าย',
                'price' => 590,
                'stock' => 60,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'รายละเอียดสินค้า'],
                    ['type' => 'text',      'data' => 'วัสดุ: Cotton 100% ไม่เป็นขน | ไซส์: 6M, 1Y, 2Y, 3Y, 4Y, 5Y'],
                    ['type' => 'paragraph', 'data' => 'ปลอดภัยสำหรับผิวเด็ก ไม่มีสารเคมีอันตราย ซักเครื่องได้'],
                ],
                'images' => [90, 91, 92],
            ],
            [
                'category' => 'children',
                'name'  => 'ของเล่น LEGO City ชุดสถานีดับเพลิง',
                'slug'  => 'lego-city-fire-station',
                'desc'  => 'ชุดเลโก้ City สถานีดับเพลิง เสริมพัฒนาการด้านความคิดสร้างสรรค์ สำหรับเด็กอายุ 6+',
                'price' => 1990,
                'stock' => 22,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'รายละเอียดสินค้า'],
                    ['type' => 'text',      'data' => 'จำนวนชิ้น: 540 ชิ้น | อายุที่แนะนำ: 6 ปีขึ้นไป'],
                    ['type' => 'paragraph', 'data' => 'มาพร้อมตัวละคร 4 ตัว รถดับเพลิง และอุปกรณ์ครบชุด'],
                ],
                'images' => [100, 101, 102],
            ],
            [
                'category' => 'children',
                'name'  => 'กระเป๋านักเรียน ลาย Unicorn สีม่วง',
                'slug'  => 'kids-unicorn-school-bag',
                'desc'  => 'กระเป๋านักเรียนลาย Unicorn น้ำหนักเบา สายปรับได้ เหมาะสำหรับเด็กประถม',
                'price' => 790,
                'stock' => 45,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'รายละเอียดสินค้า'],
                    ['type' => 'text',      'data' => 'ขนาด: 30 x 40 x 15 ซม. | น้ำหนัก: 0.5 กก. | วัสดุ: Polyester'],
                    ['type' => 'paragraph', 'data' => 'มีช่องซิปหน้า 2 ช่อง ช่องน้ำด้านข้าง สายปรับความยาวได้'],
                ],
                'images' => [110, 111, 112],
            ],

            // ── สัตว์เลี้ยง ───────────────────────────────────────
            [
                'category' => 'pets',
                'name'  => 'อาหารสุนัข Royal Canin Medium Adult 15 กก.',
                'slug'  => 'royal-canin-medium-adult-15kg',
                'desc'  => 'อาหารสุนัขพันธุ์กลาง สูตรผู้ใหญ่ ครบสารอาหาร บำรุงข้อต่อและผิวหนัง',
                'price' => 1950,
                'stock' => 30,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'รายละเอียดสินค้า'],
                    ['type' => 'text',      'data' => 'น้ำหนัก: 15 กก. | เหมาะสำหรับสุนัขอายุ 1–7 ปี น้ำหนัก 11–25 กก.'],
                    ['type' => 'paragraph', 'data' => 'เสริม Omega 3 & 6 บำรุงขนและผิวหนัง มี Glucosamine ดูแลข้อต่อ'],
                ],
                'images' => [120, 121, 122],
            ],
            [
                'category' => 'pets',
                'name'  => 'อาหารแมว Whiskas ทูน่า 1.2 กก.',
                'slug'  => 'whiskas-tuna-1-2kg',
                'desc'  => 'อาหารแมวรสทูน่า เม็ดกรอบ บำรุงสุขภาพและฟันแมว',
                'price' => 299,
                'stock' => 80,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'รายละเอียดสินค้า'],
                    ['type' => 'text',      'data' => 'น้ำหนัก: 1.2 กก. | เหมาะสำหรับแมวอายุ 1 ปีขึ้นไป'],
                    ['type' => 'paragraph', 'data' => 'ผลิตจากปลาทูน่าแท้ 100% มีวิตามิน 11 ชนิด และแร่ธาตุที่จำเป็น'],
                ],
                'images' => [130, 131, 132],
            ],
            [
                'category' => 'pets',
                'name'  => 'บ้านสุนัข ทรงโมเดิร์น ไม้สน ขนาด M',
                'slug'  => 'wooden-dog-house-modern-m',
                'desc'  => 'บ้านสุนัขทำจากไม้สนอย่างดี ทรงโมเดิร์น กันน้ำ ขนาดเหมาะสำหรับสุนัขขนาดกลาง',
                'price' => 2490,
                'stock' => 12,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'รายละเอียดสินค้า'],
                    ['type' => 'text',      'data' => 'ขนาด: 70 x 55 x 65 ซม. | วัสดุ: ไม้สนอบแห้ง เคลือบกันน้ำ'],
                    ['type' => 'paragraph', 'data' => 'ประกอบง่ายมาพร้อมคู่มือ ถอดหลังคาออกเพื่อทำความสะอาดได้'],
                ],
                'images' => [140, 141, 142],
            ],

            // ── คอมพิวเตอร์ ───────────────────────────────────────
            [
                'category' => 'computers',
                'name'  => 'โน้ตบุ๊ก ASUS VivoBook 15 Core i5 Gen 13',
                'slug'  => 'asus-vivobook-15-i5-gen13',
                'desc'  => 'โน้ตบุ๊กสำหรับการทำงานและการเรียน จอ 15.6 นิ้ว FHD กล้อง 720p',
                'price' => 18900,
                'stock' => 8,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'สเปคสินค้า'],
                    ['type' => 'text',      'data' => 'CPU: Intel Core i5-1335U | RAM: 16 GB DDR4 | SSD: 512 GB NVMe | จอ: 15.6" FHD IPS'],
                    ['type' => 'paragraph', 'data' => 'แบตเตอรี่ 50Wh ใช้ได้นาน 8 ชั่วโมง มี USB-C Thunderbolt 4 ระบบ Windows 11 Home'],
                ],
                'images' => [150, 151, 152],
            ],
            [
                'category' => 'computers',
                'name'  => 'เมาส์ Logitech MX Master 3S Wireless',
                'slug'  => 'logitech-mx-master-3s',
                'desc'  => 'เมาส์ไร้สาย Ergonomic ระดับ Pro เชื่อมต่อได้ 3 อุปกรณ์พร้อมกัน',
                'price' => 3290,
                'stock' => 25,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'รายละเอียดสินค้า'],
                    ['type' => 'text',      'data' => 'DPI: 200–8000 | แบตเตอรี่: ชาร์จ USB-C ใช้ได้นาน 70 วัน | เชื่อมต่อ: Bluetooth + Logi Bolt'],
                    ['type' => 'paragraph', 'data' => 'สกอลล์แม่เหล็ก MagSpeed ไหลลื่น เงียบ คลิกเงียบลด 90%'],
                ],
                'images' => [160, 161, 162],
            ],
            [
                'category' => 'computers',
                'name'  => 'คีย์บอร์ด Mechanical Keychron K2 Pro',
                'slug'  => 'keychron-k2-pro-mechanical',
                'desc'  => 'คีย์บอร์ด Mechanical ขนาด 75% ไร้สาย Bluetooth รองรับ Mac/Windows',
                'price' => 4590,
                'stock' => 17,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'รายละเอียดสินค้า'],
                    ['type' => 'text',      'data' => 'Switch: Gateron G Pro 3.0 Red | Backlight: RGB | Layout: 75% (84 keys)'],
                    ['type' => 'paragraph', 'data' => 'เชื่อมต่อได้ 3 อุปกรณ์พร้อมกัน ตัวเครื่อง Aluminum ทนทาน แบตเตอรี่ 4000 mAh'],
                ],
                'images' => [170, 171, 172],
            ],

            // ── โทรศัพท์มือถือ ────────────────────────────────────
            [
                'category' => 'mobile-phones',
                'name'  => 'Samsung Galaxy S24 256GB สีดำ Titanium',
                'slug'  => 'samsung-galaxy-s24-256gb-titanium-black',
                'desc'  => 'สมาร์ทโฟน Flagship จาก Samsung ชิป Snapdragon 8 Gen 3 กล้อง 50MP',
                'price' => 29900,
                'stock' => 10,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'สเปคสินค้า'],
                    ['type' => 'text',      'data' => 'CPU: Snapdragon 8 Gen 3 | RAM: 8 GB | ROM: 256 GB | จอ: 6.2" Dynamic AMOLED 2X 120Hz'],
                    ['type' => 'paragraph', 'data' => 'กล้องหลัง: 50MP + 10MP + 12MP | กล้องหน้า: 12MP | แบต: 4000 mAh | ชาร์จไร้สาย 15W'],
                ],
                'images' => [180, 181, 182],
            ],
            [
                'category' => 'mobile-phones',
                'name'  => 'iPhone 15 128GB สี Pink',
                'slug'  => 'iphone-15-128gb-pink',
                'desc'  => 'iPhone 15 ชิป A16 Bionic กล้อง 48MP Dynamic Island USB-C',
                'price' => 32900,
                'stock' => 7,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'สเปคสินค้า'],
                    ['type' => 'text',      'data' => 'CPU: A16 Bionic | ROM: 128 GB | จอ: 6.1" Super Retina XDR OLED | ชาร์จ: USB-C'],
                    ['type' => 'paragraph', 'data' => 'กล้องหลัก 48MP พร้อม 2x Optical Zoom | กล้องหน้า 12MP TrueDepth | Face ID'],
                ],
                'images' => [190, 191, 192],
            ],
            [
                'category' => 'mobile-phones',
                'name'  => 'เคสโทรศัพท์ MagSafe สำหรับ iPhone 15',
                'slug'  => 'magsafe-case-iphone-15',
                'desc'  => 'เคสใส MagSafe รองรับการชาร์จไร้สาย กันกระแทก ขอบกันรอย',
                'price' => 590,
                'stock' => 100,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'รายละเอียดสินค้า'],
                    ['type' => 'text',      'data' => 'วัสดุ: Polycarbonate + TPU | รองรับ: MagSafe Charging | รุ่น: iPhone 15 / 15 Plus'],
                    ['type' => 'paragraph', 'data' => 'ใสทนทาน ไม่เหลืองง่าย กันรอยกล้อง ขอบนูนป้องกันจอ'],
                ],
                'images' => [200, 201, 202],
            ],

            // ── บ้านและสวน ────────────────────────────────────────
            [
                'category' => 'home-garden',
                'name'  => 'โคมไฟตั้งโต๊ะ LED หรี่แสงได้ สีทอง',
                'slug'  => 'led-desk-lamp-dimmable-gold',
                'desc'  => 'โคมไฟตั้งโต๊ะ LED หรี่แสงได้ 3 ระดับ ดีไซน์ Minimal สีทองหรูหรา',
                'price' => 1290,
                'stock' => 20,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'รายละเอียดสินค้า'],
                    ['type' => 'text',      'data' => 'กำลังไฟ: 12W | แสง: 3 โทน (warm/neutral/cool) | ปลั๊ก: USB-C + AC Adapter'],
                    ['type' => 'paragraph', 'data' => 'ปรับความสว่างได้ 5 ระดับ หัวโคมปรับได้ 360° ประหยัดพลังงาน'],
                ],
                'images' => [210, 211, 212],
            ],
            [
                'category' => 'home-garden',
                'name'  => 'กระถางต้นไม้ ซีเมนต์ มินิมอล ชุด 3 ใบ',
                'slug'  => 'cement-plant-pot-set-3',
                'desc'  => 'กระถางซีเมนต์ดีไซน์มินิมอล เหมาะตกแต่งบ้านและออฟฟิศ ชุด 3 ใบ ขนาดต่างกัน',
                'price' => 490,
                'stock' => 55,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'รายละเอียดสินค้า'],
                    ['type' => 'text',      'data' => 'ขนาด S: 8 ซม., M: 12 ซม., L: 16 ซม. | วัสดุ: ซีเมนต์ผสมทราย'],
                    ['type' => 'paragraph', 'data' => 'มีรูระบายน้ำที่ก้น เหมาะสำหรับไม้อวบน้ำ Succulent และต้นไม้เล็ก'],
                ],
                'images' => [220, 221, 222],
            ],
            [
                'category' => 'home-garden',
                'name'  => 'หมอนโซฟา ผ้า Velvet ทรงสี่เหลี่ยม 45x45 ซม.',
                'slug'  => 'velvet-sofa-cushion-45x45',
                'desc'  => 'หมอนอิงโซฟาผ้า Velvet นุ่มหนา สีเขียวมอส ตกแต่งบ้านสไตล์ Nordic',
                'price' => 390,
                'stock' => 70,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'รายละเอียดสินค้า'],
                    ['type' => 'text',      'data' => 'ขนาด: 45 x 45 ซม. | วัสดุ: Velvet | ไส้หมอน: Polyester Fiber นุ่มสปริง'],
                    ['type' => 'paragraph', 'data' => 'ซักมือได้ที่อุณหภูมิ 30°C มีให้เลือก 8 สี เหมาะกับโซฟาทุกสไตล์'],
                ],
                'images' => [230, 231, 232],
            ],

            // ── อุปกรณ์อิเล็กทรอนิกส์ ────────────────────────────
            [
                'category' => 'electronics',
                'name'  => 'ทีวี Samsung QLED 55 นิ้ว 4K Smart TV',
                'slug'  => 'samsung-qled-55-4k-smart-tv',
                'desc'  => 'ทีวี QLED ความละเอียด 4K 120Hz รองรับ HDR10+ Dolby Atmos Smart TV',
                'price' => 24900,
                'stock' => 6,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'สเปคสินค้า'],
                    ['type' => 'text',      'data' => 'ขนาด: 55 นิ้ว | ความละเอียด: 4K UHD | อัตราการรีเฟรช: 120Hz | OS: Tizen'],
                    ['type' => 'paragraph', 'data' => 'รองรับ Netflix, YouTube, Prime Video | มี HDMI 4 พอร์ต | เสียง 40W Dolby Atmos'],
                ],
                'images' => [240, 241, 242],
            ],
            [
                'category' => 'electronics',
                'name'  => 'หูฟัง Sony WH-1000XM5 ANC Wireless',
                'slug'  => 'sony-wh-1000xm5-anc',
                'desc'  => 'หูฟัง Bluetooth ตัดเสียง Active Noise Cancelling ระดับ Pro',
                'price' => 12900,
                'stock' => 14,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'รายละเอียดสินค้า'],
                    ['type' => 'text',      'data' => 'ชิป: V1 Processor | แบต: 30 ชั่วโมง | ชาร์จ: USB-C | Bluetooth 5.2'],
                    ['type' => 'paragraph', 'data' => 'ANC ลดเสียงรบกวนได้ถึง 30 dB รองรับ Multipoint เชื่อมต่อ 2 อุปกรณ์พร้อมกัน'],
                ],
                'images' => [250, 251, 252],
            ],
            [
                'category' => 'electronics',
                'name'  => 'กล้องดิจิตอล Sony ZV-E10 II Kit 16-50mm',
                'slug'  => 'sony-zv-e10-ii-kit-16-50',
                'desc'  => 'กล้อง Mirrorless สำหรับ Vlogger เซ็นเซอร์ APS-C 26MP ถ่าย 4K',
                'price' => 27900,
                'stock' => 5,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'สเปคสินค้า'],
                    ['type' => 'text',      'data' => 'Sensor: APS-C 26.1MP | วิดีโอ: 4K 60fps | AF: ตรวจจับตาและใบหน้า | LCD: Flip 180°'],
                    ['type' => 'paragraph', 'data' => 'มาพร้อมเลนส์ 16-50mm f/3.5-5.6 มีไมค์ใน Vlog Mode เหมาะสำหรับ Content Creator'],
                ],
                'images' => [260, 261, 262],
            ],
            [
                'category' => 'electronics',
                'name'  => 'ลำโพง Bluetooth JBL Charge 5 กันน้ำ IPX7',
                'slug'  => 'jbl-charge-5-bluetooth-speaker',
                'desc'  => 'ลำโพง Portable กันน้ำ IPX7 เสียงทรงพลัง แบตเตอรี่ 20 ชั่วโมง',
                'price' => 4990,
                'stock' => 20,
                'blocks' => [
                    ['type' => 'heading',   'data' => 'รายละเอียดสินค้า'],
                    ['type' => 'text',      'data' => 'กำลังขับ: 40W | แบต: 7500 mAh ใช้งานได้ 20 ชั่วโมง | Bluetooth 5.1'],
                    ['type' => 'paragraph', 'data' => 'กันน้ำ IPX7 จมน้ำได้ถึง 1 ม. เชื่อมต่อ PartyBoost หลายตัวพร้อมกัน ชาร์จ USB-C'],
                ],
                'images' => [270, 271, 272],
            ],
        ];

        // ============================================================
        // บันทึกสินค้าทั้งหมด
        // ============================================================
        foreach ($products as $data) {
            $product = Product::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'name'           => $data['name'],
                    'description'    => $data['desc'],
                    'content_blocks' => $data['blocks'],
                    'price'          => $data['price'],
                    'stock_quantity' => $data['stock'],
                    'is_active'      => true,
                ]
            );

            // ผูกหมวดหมู่
            if (isset($cats[$data['category']])) {
                $product->categories()->syncWithoutDetaching([$cats[$data['category']]->id]);
            }

            // สร้างรูปภาพ (ถ้ายังไม่มี)
            if ($product->images()->count() === 0) {
                foreach ($data['images'] as $i => $seed) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => "https://picsum.photos/seed/{$seed}/600/600",
                        'is_primary' => $i === 0,
                        'sort_order' => $i,
                    ]);
                }
            }
        }
    }
}
