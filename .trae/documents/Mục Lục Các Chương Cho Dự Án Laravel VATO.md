# Mục Lục Báo Cáo Dự Án

## Chương 1: Tổng quan về đề tài
1. Giới thiệu đề tài và bối cảnh
2. Lý do chọn đề tài
3. Mục tiêu đề tài
4. Phạm vi thực hiện và đối tượng sử dụng
5. Dự kiến công việc và phân công
6. Công nghệ, thư viện sử dụng
   - Backend: PHP 8.2, Laravel 12 (`composer.json`:12–15)
   - Frontend: Vite 7, TailwindCSS 4, Axios (`package.json`:10–16; `vite.config.js`:1–13)
   - Công cụ phát triển và test: Pest, Mockery (`composer.json`:16–25; 51–54)

## Chương 2: Khảo sát và phân tích yêu cầu
1. Tìm hiểu nghiệp vụ ứng dụng thuê xe
   - Vai trò: Người dùng, Chủ xe (Owner), Quản trị (Admin)
2. Phân tích yêu cầu chức năng (theo tuyến `routes/web.php`:17–66)
   - Người dùng: xem trang chủ, danh mục, chi tiết xe, đặt/hủy chuyến (`HomeController`, `CategoryController`, `CarController`, `TripController`)
   - Xác thực: đăng ký/đăng nhập/đăng xuất (`AuthController`)
   - Chủ xe: tạo/cập nhật/xóa xe (`OwnerController`)
   - Quản trị: dashboard, quản lý xe, người dùng, đơn đặt (`Admin*Controller`)
3. Đối tượng và ca sử dụng chính (Use Case)
   - UC1: Đăng ký/đăng nhập
   - UC2: Duyệt xe theo danh mục
   - UC3: Đặt xe, hủy đặt
   - UC4: Chủ xe quản lý danh sách xe
   - UC5: Admin quản trị hệ thống

## Chương 3: Thiết kế hệ thống và cơ sở dữ liệu
1. Kiến trúc ứng dụng
   - MVC Laravel, định tuyến và điều khiển (`routes/web.php`:17–66; `app/Http/Controllers/*`)
   - Tổ chức tài nguyên frontend (`resources/css|js|views`)
2. Thiết kế cơ sở dữ liệu (ERD & quan hệ)
   - Bảng: `users`, `cars`, `categories`, `car_category` (pivot), `bookings`, `sessions`, `jobs`, `cache`
   - Migrations: `database/migrations` liệt kê đầy đủ (ví dụ: `create_cars_table.php`, `create_bookings_table.php`)
   - Đặc điểm: `images` JSON cho xe, chỉ số tối ưu (`add_indexes_to_cars_and_bookings.php`)
3. Ràng buộc và mô hình dữ liệu
   - Quan hệ: Người dùng–Đơn đặt, Xe–Danh mục (N-N), Chủ xe–Xe

## Chương 4: Lập trình xây dựng và cài đặt hệ thống
1. Xây dựng database trên MySQL
   - Chạy migrations & seeders (danh sách seeders trong `database/seeders/`)
2. Tổ chức mã nguồn
   - Cấu trúc thư mục (`app/`, `resources/`, `routes/`, `database/`, `public/`) và chức năng từng phần
3. Xây dựng các chức năng theo thiết kế
   - Frontend: build bằng Vite/Tailwind (`vite.config.js`:5–12; `resources/js/app.js`, `resources/css/app.css`)
   - Backend: các controller và luồng xử lý chính (`App\Http\Controllers\*`)
   - Admin module: quản trị xe/người dùng/đơn đặt (`Admin*Controller`)
   - Chủ xe: CRUD xe (`OwnerController`)
   - Người dùng: xem xe, đặt/hủy chuyến (`TripController`)
4. Cấu hình và chạy hệ thống
   - Lệnh dev kết hợp server/queue/vite (`composer.json`:47–50)
   - Lệnh thiết lập và build (`composer.json`:39–46)

## Chương 5: Kết luận
1. Tổng kết kết quả đạt được
2. Hạn chế và hướng phát triển

## Tài liệu tham khảo
1. Tài liệu chính thức Laravel, Vite, TailwindCSS
2. Các nguồn tham khảo liên quan đến thiết kế hệ thống thuê xe

---

## Phạm vi bàn giao
- Giao mục lục chi tiết theo cấu trúc trên, bám sát mã nguồn thực tế.
- Khi bạn xác nhận, tôi sẽ chuyển mục lục này thành khung nội dung chi tiết (mỗi mục kèm mô tả ngắn, trích dẫn file cụ thể như `routes/web.php:17–66`, `composer.json:39–50`) để bạn dùng trực tiếp trong báo cáo.