# UI/UX Design - Hệ Thống Quản Lý Phòng Trọ

**Ngày tạo**: 21-06-2026  
**Phiên bản**: 1.0  
**Trạng thái**: Draft - Hoàn thiện

---

## Mục Lục

1. [Sitemap Hệ Thống](#sitemap-hệ-thống)
2. [Wireframes Chi Tiết](#wireframes-chi-tiết)
3. [Danh Sách Components](#danh-sách-components)
4. [Thiết Kế Dashboard](#thiết-kế-dashboard)
5. [CRUD Design Patterns](#crud-design-patterns)
6. [Đề Xuất UX/UI Tối Ưu](#đề-xuất-uxui-tối-ưu)
7. [Color Scheme & Styling](#color-scheme--styling)

---

## Sitemap Hệ Thống

```
MOTEL MANAGEMENT SYSTEM
│
├── DASHBOARD (Trang Chủ)
│   ├── KPI Cards (11 thẻ thống kê)
│   ├── Charts (4 biểu đồ)
│   └── Recent Tables (3 bảng dữ liệu gần đây)
│
├── QUẢN LÝ BẤT ĐỘNG SẢN
│   ├── Khu Vực
│   │   ├── Danh Sách (DataTable)
│   │   ├── Thêm Mới
│   │   ├── Chỉnh Sửa
│   │   └── Xem Chi Tiết
│   │
│   ├── Tòa Nhà
│   │   ├── Danh Sách (DataTable + Filter Khu Vực)
│   │   ├── Thêm Mới
│   │   ├── Chỉnh Sửa
│   │   └── Xem Chi Tiết
│   │
│   └── Căn Hộ
│       ├── Xem theo Card Layout (với Filter)
│       ├── Xem theo Table Layout (DataTable)
│       ├── Sơ Đồ Tầng (Floor Plan)
│       ├── Thêm Mới
│       ├── Chỉnh Sửa
│       └── Xem Chi Tiết
│
├── QUẢN LÝ KHÁCH HÀNG
│   ├── Danh Sách Khách Hàng
│   │   ├── DataTable
│   │   ├── Avatar
│   │   ├── Thêm Mới
│   │   ├── Chỉnh Sửa
│   │   └── Xem Chi Tiết
│   │
│   └── Thông Tin Cá Nhân
│       ├── Profile Khách Hàng
│       ├── Hợp Đồng Đang Thuê
│       ├── Lịch Sử Hóa Đơn
│       └── Lịch Sử Thanh Toán
│
├── QUẢN LÝ HỢP ĐỒNG
│   ├── Danh Sách Hợp Đồng
│   │   ├── DataTable
│   │   ├── Filter (Trạng Thái, Khu Vực, Khách Hàng)
│   │   ├── Thêm Mới
│   │   ├── Chỉnh Sửa
│   │   ├── Xem Chi Tiết (Timeline)
│   │   └── Gia Hạn / Hủy Bỏ
│   │
│   └── Hợp Đồng Chi Tiết
│       ├── Thông Tin Chính
│       ├── Timeline Vòng Đời
│       ├── Danh Sách Hóa Đơn
│       └── Hành Động (Gia Hạn, Hủy, In PDF)
│
├── QUẢN LÝ TÀI CHÍNH
│   ├── Hóa Đơn
│   │   ├── Danh Sách Hóa Đơn (DataTable)
│   │   ├── Filter (Trạng Thái, Tháng, Năm)
│   │   ├── Thêm Mới
│   │   ├── Chỉnh Sửa
│   │   ├── Xem Chi Tiết
│   │   ├── In PDF
│   │   ├── Gửi Email
│   │   └── Đánh Dấu Thanh Toán
│   │
│   └── Thu Chi
│       ├── Danh Sách Giao Dịch (DataTable)
│       ├── Filter (Loại, Tháng, Năm)
│       ├── Mini Dashboard (Tổng Thu, Tổng Chi, Lợi Nhuận)
│       ├── Thêm Mới
│       ├── Chỉnh Sửa
│       └── Xem Chi Tiết
│
├── BÁO CÁO & THỐNG KÊ
│   ├── Báo Cáo Tháng
│   │   ├── Filter & Chọn Tháng
│   │   ├── Biểu Đồ Doanh Thu
│   │   ├── Biểu Đồ Chi Phí
│   │   ├── Biểu Đồ Lợi Nhuận
│   │   ├── KPI Cards
│   │   └── Nút In PDF / Export Excel
│   │
│   ├── Báo Cáo Quý
│   │   └── [Tương tự Báo Cáo Tháng]
│   │
│   └── Báo Cáo Năm
│       └── [Tương tự Báo Cáo Tháng]
│
└── HỆ THỐNG
    ├── Tài Khoản Người Dùng
    │   ├── Danh Sách (DataTable)
    │   ├── Thêm Mới
    │   ├── Chỉnh Sửa
    │   └── Xóa
    │
    ├── Phân Quyền
    │   ├── Danh Sách Role
    │   ├── Cấu Hình Quyền
    │   └── Gán Quyền cho User
    │
    └── Cài Đặt
        ├── Cài Đặt Chung
        ├── Cài Đặt Email
        ├── Cài Đặt Báo Cáo
        └── Backup Dữ Liệu
```

---

## Wireframes Chi Tiết

### 1. Main Layout (Tất Cả Trang)

```
┌─────────────────────────────────────────────────────┐
│  NAVBAR (Cố định)                                   │
│  [Logo] [Search] [Notifications] [Avatar] [Logout]  │
└─────────────────────────────────────────────────────┘
┌─────────────┬───────────────────────────────────────┐
│             │                                       │
│  SIDEBAR    │  CONTENT AREA (Responsive)            │
│  (Collap-   │  [Breadcrumb]                         │
│   sible)    │  [Page Title]                         │
│             │  [Filters/Actions]                    │
│  ├── 📊      │  ┌─────────────────────────────────┐│
│  │Dashboard  │  │  Main Content                   ││
│  │           │  │  (Cards/Table/Chart/Form)      ││
│  │           │  │                                 ││
│  │           │  │                                 ││
│  │           │  └─────────────────────────────────┘│
│  ├── 🏢      │  [Pagination / Scroll]              │
│  │Real Estate│                                     │
│  │           │                                     │
│  ├── 👥      │                                     │
│  │Customers  │                                     │
│  │           │                                     │
│  ├── 📋      │                                     │
│  │Contracts  │                                     │
│  │           │                                     │
│  ├── 💰      │                                     │
│  │Finance    │                                     │
│  │           │                                     │
│  ├── 📈      │                                     │
│  │Reports    │                                     │
│  │           │                                     │
│  └── ⚙️      │                                     │
│   System    │                                     │
└─────────────┴───────────────────────────────────────┘
```

### 2. Dashboard

```
┌──────────────────────────────────────────────────────────────┐
│ Dashboard > Home                                             │
└──────────────────────────────────────────────────────────────┘

┌─ KPI Cards Row 1 ─────────────────────────────────────────────┐
│                                                               │
│  ┌──────────────┐ ┌──────────────┐ ┌──────────────┐          │
│  │ Khu Vực      │ │ Tòa Nhà      │ │ Căn Hộ       │          │
│  │   25         │ │    180       │ │   1,250      │          │
│  │ +5 từ tháng  │ │ +15 từ tháng │ │ +50 từ tháng │          │
│  └──────────────┘ └──────────────┘ └──────────────┘          │
│  ┌──────────────┐ ┌──────────────┐ ┌──────────────┐          │
│  │ Đang Thuê    │ │ Trống        │ │ Khách Hàng   │          │
│  │    850       │ │     200      │ │    620       │          │
│  │  68%         │ │    16%       │ │ +10 mới      │          │
│  └──────────────┘ └──────────────┘ └──────────────┘          │
│  ┌──────────────┐ ┌──────────────┐ ┌──────────────┐          │
│  │ Hợp Đồng     │ │ Hóa Đơn      │ │ Doanh Thu    │          │
│  │  Hiệu Lực    │ │ Chưa TT      │ │ Tháng Này    │          │
│  │    750       │ │    45        │ │ 850 Triệu đ  │          │
│  └──────────────┘ └──────────────┘ └──────────────┘          │
│  ┌──────────────┐ ┌──────────────┐                           │
│  │ Chi Phí      │ │ Lợi Nhuận    │                           │
│  │ Tháng Này    │ │ Tháng Này    │                           │
│  │ 180 Triệu đ  │ │ 670 Triệu đ  │                           │
│  └──────────────┘ └──────────────┘                           │
│                                                               │
└─────────────────────────────────────────────────────────────┘

┌─ Charts Row ──────────────────────────────────────────────────┐
│                                                               │
│  ┌────────────────────────────┐ ┌────────────────────────────┐│
│  │ Doanh Thu 6 Tháng Gần Đây   │ │ Chi Phí vs Doanh Thu       ││
│  │ [Line Chart]               │ │ [Bar Chart]               ││
│  │                            │ │                           ││
│  │                            │ │                           ││
│  └────────────────────────────┘ └────────────────────────────┘│
│  ┌────────────────────────────┐ ┌────────────────────────────┐│
│  │ Tỷ Lệ Căn Hộ (Donut Chart) │ │ Tỷ Lệ Thanh Toán HĐ      ││
│  │                            │ │ [Donut Chart]             ││
│  │  Đang Thuê: 68%            │ │ Đã TT: 92%                ││
│  │  Trống: 16%                │ │ Chưa TT: 8%               ││
│  │  Bảo Trì: 2%               │ │                           ││
│  └────────────────────────────┘ └────────────────────────────┘│
│                                                               │
└─────────────────────────────────────────────────────────────┘

┌─ Tables Row ──────────────────────────────────────────────────┐
│                                                               │
│ ┌─ Hóa Đơn Sắp Đến Hạn ─────────────────────────────────────┐│
│ │ Mã HĐ   │ Khách     │ Số Tiền      │ Hạn       │ Thao Tác ││
│ │ INV-001 │ Nguyễn A  │ 5.5 Triệu    │ 25/06    │ [Chi Tiết]││
│ │ INV-002 │ Trần B    │ 5.0 Triệu    │ 26/06    │ [Chi Tiết]││
│ │ INV-003 │ Lê C      │ 6.0 Triệu    │ 27/06    │ [Chi Tiết]││
│ └────────────────────────────────────────────────────────────┘│
│                                                               │
│ ┌─ Hợp Đồng Sắp Hết Hạn ─────────────────────────────────────┐│
│ │ Mã HD  │ Khách     │ Căn Hộ │ Hết Hạn   │ Ngày Hạn  │ Thao Tác││
│ │ CT-001 │ Nguyễn A  │ A101   │ 30 ngày   │ 21/07    │ [Gia Hạn]││
│ │ CT-002 │ Trần B    │ B205   │ 60 ngày   │ 20/08    │ [Chi Tiết]││
│ └────────────────────────────────────────────────────────────┘│
│                                                               │
│ ┌─ Khách Hàng Mới ────────────────────────────────────────────┐│
│ │ Tên          │ CCCD       │ Điện Thoại    │ Ngày Tạo  │ Thao Tác││
│ │ Phạm Văn D   │ 123456789  │ 0987654321    │ 20/06    │ [Chi Tiết]││
│ │ Hoàng Thị E  │ 987654321  │ 0912345678    │ 19/06    │ [Chi Tiết]││
│ └────────────────────────────────────────────────────────────┘│
│                                                               │
└─────────────────────────────────────────────────────────────┘
```

### 3. Danh Sách Module (DataTable Pattern)

```
┌─ Quản Lý Khu Vực ─────────────────────────────────────────────┐
│ [Breadcrumb: Trang Chủ > Bất Động Sản > Khu Vực]             │
│                                                               │
│ ┌─ Toolbar ─────────────────────────────────────────────────┐ │
│ │ [📥 Import] [➕ Thêm Mới] [⚙️ Cờlumn] [🔄 Refresh]  [📤 Export] │
│ │ [🔍 Search: ____________] [Filter ▼]  [Rows: 25 ▼]       │ │
│ └───────────────────────────────────────────────────────────┘ │
│                                                               │
│ ┌─ Table ───────────────────────────────────────────────────┐ │
│ │ ☑  │ STT │ Tên Khu Vực │ Địa Chỉ    │ Tòa Nhà │ Ngày Tạo │ │
│ │─────┼─────┼─────────────┼────────────┼────────┼──────────┤ │
│ │ ☐ │ 1   │ Khu A       │ 123 ABC St │ 15     │ 10/01   │ │
│ │    │     │ [Chỉnh sửa] │            │        │ 2026    │ │
│ │    │     │ [Xóa]      │            │        │         │ │
│ │    │     │ [Chi tiết]  │            │        │         │ │
│ │─────┼─────┼─────────────┼────────────┼────────┼──────────┤ │
│ │ ☐ │ 2   │ Khu B       │ 456 DEF St │ 18     │ 15/01   │ │
│ │    │     │ [Chỉnh sửa] │            │        │ 2026    │ │
│ │    │     │ [Xóa]      │            │        │         │ │
│ │    │     │ [Chi tiết]  │            │        │         │ │
│ │─────┼─────┼─────────────┼────────────┼────────┼──────────┤ │
│ │ ☐ │ 3   │ Khu C       │ 789 GHI St │ 12     │ 20/01   │ │
│ │    │     │ [Chỉnh sửa] │            │        │ 2026    │ │
│ │    │     │ [Xóa]      │            │        │         │ │
│ │    │     │ [Chi tiết]  │            │        │         │ │
│ └─────┴─────┴─────────────┴────────────┴────────┴──────────┘ │
│                                                               │
│ Showing 1 to 3 of 25  [<] 1 2 3 ... 9 [>]                    │
└─────────────────────────────────────────────────────────────┘
```

### 4. Trang Căn Hộ - Card View

```
┌─ Quản Lý Căn Hộ ──────────────────────────────────────────────┐
│ [Breadcrumb: Trang Chủ > Bất Động Sản > Căn Hộ]              │
│                                                               │
│ ┌─ Toolbar ─────────────────────────────────────────────────┐ │
│ │ [➕ Thêm] [🗺️ Sơ Đồ Tầng] [View: Grid ▼] [Filter ▼] [📥 ]   │
│ │ [🔍 Search ________] [Tòa Nhà: ▼] [Trạng Thái: ▼]         │ │
│ └───────────────────────────────────────────────────────────┘ │
│                                                               │
│ ┌─ Card Grid ───────────────────────────────────────────────┐ │
│ │ ┌────────────────┐ ┌────────────────┐ ┌────────────────┐  │ │
│ │ │ A101           │ │ A102           │ │ A103           │  │ │
│ │ │ Tòa A, Tầng 1  │ │ Tòa A, Tầng 1  │ │ Tòa A, Tầng 1  │  │ │
│ │ │                │ │                │ │                │  │ │
│ │ │ ⏳ Đang Thuê   │ │ ✅ Trống       │ │ 🔧 Bảo Trì     │  │ │
│ │ │                │ │                │ │                │  │ │
│ │ │ 35 m²          │ │ 35 m²          │ │ 35 m²          │  │ │
│ │ │ Giá: 5.5T đ    │ │ Giá: 5.5T đ    │ │ Giá: 5.5T đ    │  │ │
│ │ │                │ │                │ │                │  │ │
│ │ │ [Xem] [Sửa]    │ │ [Xem] [Sửa]    │ │ [Xem] [Sửa]    │  │ │
│ │ └────────────────┘ └────────────────┘ └────────────────┘  │ │
│ │                                                             │ │
│ │ ┌────────────────┐ ┌────────────────┐ ┌────────────────┐  │ │
│ │ │ B201           │ │ B202           │ │ B203           │  │ │
│ │ │ Tòa B, Tầng 2  │ │ Tòa B, Tầng 2  │ │ Tòa B, Tầng 2  │  │ │
│ │ │ ...            │ │ ...            │ │ ...            │  │ │
│ │ └────────────────┘ └────────────────┘ └────────────────┘  │ │
│ └─────────────────────────────────────────────────────────────┘ │
│                                                               │
└─────────────────────────────────────────────────────────────┘
```

### 5. Floor Plan (Sơ Đồ Tầng)

```
┌─ Sơ Đồ Tầng Tòa A ────────────────────────────────────────────┐
│ [Chọn Tầng: 1 ▼] [Chọn Tòa: Tòa A ▼]                        │
│                                                               │
│                 TẦNG 1                                        │
│                                                               │
│  ┌──────────────────────────────────┐                         │
│  │  A101      ⏳ Đang Thuê          │                         │
│  │  Nguyễn A                        │                         │
│  │                                  │                         │
│  └──────────────────────────────────┘                         │
│           │                          │                        │
│  ┌────────────────┐       ┌──────────────────┐               │
│  │  A102         │       │  A103            │               │
│  │  ✅ Trống     │       │  ⏳ Đang Thuê    │               │
│  │  (5.5T đ)     │       │  Trần B          │               │
│  │               │       │  (5.5T đ)        │               │
│  └────────────────┘       └──────────────────┘               │
│           │                        │                         │
│  ┌────────────────┐       ┌──────────────────┐               │
│  │  A104         │       │  A105            │               │
│  │  ✅ Trống     │       │  🔧 Bảo Trì     │               │
│  │  (5.5T đ)     │       │  (5.5T đ)        │               │
│  │               │       │                  │               │
│  └────────────────┘       └──────────────────┘               │
│                                                               │
│ Legend:                                                       │
│ ✅ Trống (Xanh)  ⏳ Đang Thuê (Xanh Dương)  🔧 Bảo Trì (Đỏ) │
│                                                               │
└─────────────────────────────────────────────────────────────┘
```

### 6. Form Add/Edit Căn Hộ

```
┌─ Thêm Mới Căn Hộ ─────────────────────────────────────────────┐
│                                                               │
│ ┌─ Thông Tin Cơ Bản ────────────────────────────────────────┐ │
│ │ Tòa Nhà:        [Chọn Tòa ▼________________]           │ │
│ │                                                        │ │
│ │ Mã Căn Hộ:      [A101________________]                │ │
│ │                 ⚠️ Bắt buộc, định dạng: XNNN          │ │
│ │                                                        │ │
│ │ Tầng:           [1________________]                   │ │
│ │                                                        │ │
│ │ Diện Tích (m²): [35_______________]                   │ │
│ │                                                        │ │
│ │ Số Phòng:       [1________________]                   │ │
│ │                                                        │ │
│ └────────────────────────────────────────────────────────┘ │
│                                                               │
│ ┌─ Giá Thuê & Trạng Thái ───────────────────────────────────┐ │
│ │ Giá Thuê (VNĐ): [5500000_______]                      │ │
│ │                                                        │ │
│ │ Trạng Thái:     ⦿ Trong                               │ │
│ │                 ⦯ Đang Thuê                           │ │
│ │                 ⦯ Bảo Trì                            │ │
│ │                                                        │ │
│ └────────────────────────────────────────────────────────┘ │
│                                                               │
│ ┌─ Thông Tin Bổ Sung ───────────────────────────────────────┐ │
│ │ Mô Tả:          [_________________________]            │ │
│ │                 [_________________________]            │ │
│ │                 [_________________________]            │ │
│ └────────────────────────────────────────────────────────┘ │
│                                                               │
│                      [Hủy]  [💾 Lưu]                        │
│                                                               │
└─────────────────────────────────────────────────────────────┘
```

### 7. Trang Chi Tiết Hợp Đồng - Timeline View

```
┌─ Hợp Đồng CT-001 ─────────────────────────────────────────────┐
│ [Quay Lại] [In PDF] [Gửi Email] [Gia Hạn] [Hủy Bỏ] [Sửa]    │
│                                                               │
│ ┌─ Thông Tin Hợp Đồng ──────────────────────────────────────┐ │
│ │ Mã Hợp Đồng: CT-001                                    │ │
│ │ Khách Hàng: Nguyễn Văn A                               │ │
│ │ Căn Hộ: A101 (Tòa A, Tầng 1) - 35m²                   │ │
│ │ Giá Thuê: 5.5 Triệu đ/tháng                            │ │
│ │ Tiền Cọc: 11 Triệu đ (2 tháng)                         │ │
│ │ Phương Thức TT: Chuyển Khoản, Chu Kỳ: Hàng Tháng      │ │
│ └────────────────────────────────────────────────────────┘ │
│                                                               │
│ ┌─ Timeline Vòng Đời Hợp Đồng ──────────────────────────────┐ │
│ │                                                         │ │
│ │  ✅ Ký Kết           ✅ Hoạt Động         ⏳ Sắp Hết    │ │
│ │  01/01/2026         01/01 → 31/12/2026    Hạn: 31/12  │ │
│ │       │                      │                  │       │ │
│ │       └──────────────────────┴──────────────────┘       │ │
│ │                                                         │ │
│ │  Trạng Thái Hiện Tại: Hiệu Lực                         │ │
│ │  Ngày Còn Lại: 195 ngày                               │ │
│ │                                                         │ │
│ └─────────────────────────────────────────────────────────┘ │
│                                                               │
│ ┌─ Danh Sách Hóa Đơn ───────────────────────────────────────┐ │
│ │ Mã HĐ   │ Kỳ  │ Ngày Phát │ Hạn      │ Số Tiền │ Trạng Thái││
│ │ INV-001 │ 1   │ 01/01    │ 05/02   │ 5.5T đ  │ ✅ Đã TT  ││
│ │ INV-002 │ 2   │ 01/02    │ 05/03   │ 5.5T đ  │ ✅ Đã TT  ││
│ │ INV-003 │ 3   │ 01/03    │ 05/04   │ 5.5T đ  │ ✅ Đã TT  ││
│ │ ...     │ ... │ ...      │ ...     │ ...     │ ...      ││
│ └────────────────────────────────────────────────────────────┘ │
│                                                               │
└─────────────────────────────────────────────────────────────┘
```

### 8. Trang Hóa Đơn

```
┌─ Quản Lý Hóa Đơn ─────────────────────────────────────────────┐
│ [Breadcrumb: Trang Chủ > Tài Chính > Hóa Đơn]               │
│                                                               │
│ ┌─ Toolbar ─────────────────────────────────────────────────┐ │
│ │ [➕ Thêm] [📤 Export] [🔍 Search _______] [Filter ▼]      │ │
│ │ [Trạng Thái: Tất Cả ▼] [Tháng: 6 ▼] [Năm: 2026 ▼]       │ │
│ └───────────────────────────────────────────────────────────┘ │
│                                                               │
│ ┌─ Table ───────────────────────────────────────────────────┐ │
│ │ ☑  │ Mã HĐ  │ Khách HH   │ Số Tiền │ Hạn   │ Trạng Thái│ │
│ │────┼────────┼────────────┼─────────┼───────┼──────────┤ │
│ │ ☐ │ INV-001│ Nguyễn A   │ 5.5T đ │ 25/06 │ ✅ Đã TT │ │
│ │    │        │ Căn A101   │         │       │          │ │
│ │    │        │ [Chi Tiết] │ [In] [Email]    │          │ │
│ │────┼────────┼────────────┼─────────┼───────┼──────────┤ │
│ │ ☐ │ INV-002│ Trần B     │ 5.0T đ │ 26/06 │ ⏳ Chưa TT │ │
│ │    │        │ Căn B201   │         │       │          │ │
│ │    │        │ [Chi Tiết] │ [In] [Email]    │          │ │
│ │────┼────────┼────────────┼─────────┼───────┼──────────┤ │
│ │ ☐ │ INV-003│ Lê C       │ 6.0T đ │ 27/06 │ ⚠️ Quá Hạn│ │
│ │    │        │ Căn C305   │         │       │          │ │
│ │    │        │ [Chi Tiết] │ [In] [Email]    │          │ │
│ └─────────────────────────────────────────────────────────────┘ │
│                                                               │
│ Tóm Tắt: Tổng: 50 | Đã TT: 46 (92%) | Chưa TT: 3 (6%) │ │
│          Tổng Tiền: 275 Triệu đ | Nợ: 18 Triệu đ        │
│                                                               │
└─────────────────────────────────────────────────────────────┘
```

### 9. Trang Báo Cáo Tài Chính

```
┌─ Báo Cáo Tháng 6 Năm 2026 ────────────────────────────────────┐
│ [Breadcrumb: Trang Chủ > Báo Cáo > Báo Cáo Tháng]           │
│                                                               │
│ ┌─ Toolbar Filter ──────────────────────────────────────────┐ │
│ │ Loại Báo Cáo: [Tháng ▼] [Quý ▼] [Năm ▼]                │ │
│ │ Chọn: [Tháng 6 ▼] [Năm 2026 ▼] [🔄 Cập Nhật]           │ │
│ │                              [📥 In PDF] [📤 Export]      │ │
│ └───────────────────────────────────────────────────────────┘ │
│                                                               │
│ ┌─ KPI Cards ───────────────────────────────────────────────┐ │
│ │                                                         │ │
│ │  ┌──────────────┐ ┌──────────────┐ ┌──────────────┐   │ │
│ │  │ Tổng Thu     │ │ Tổng Chi     │ │ Lợi Nhuận    │   │ │
│ │  │ 850 Triệu đ  │ │ 180 Triệu đ  │ │ 670 Triệu đ  │   │ │
│ │  │ ↑ 5% YoY     │ │ ↓ 2% YoY     │ │ ↑ 8% YoY     │   │ │
│ │  └──────────────┘ └──────────────┘ └──────────────┘   │ │
│ │                                                         │ │
│ │  ┌──────────────┐ ┌──────────────┐ ┌──────────────┐   │ │
│ │  │ Tổng Tiền    │ │ Số Dư        │ │ Tỷ Suất LN   │   │ │
│ │  │ Thuê         │ │ (Tài Chính)  │ │              │   │ │
│ │  │ 850 Triệu đ  │ │ 670 Triệu đ  │ │ 78.8%        │   │ │
│ │  └──────────────┘ └──────────────┘ └──────────────┘   │ │
│ │                                                         │ │
│ └─────────────────────────────────────────────────────────┘ │
│                                                               │
│ ┌─ Charts ──────────────────────────────────────────────────┐ │
│ │ ┌────────────────────────────┐ ┌────────────────────────┐ │
│ │ │ Doanh Thu Chi Tiết         │ │ Chi Phí Chi Tiết       │ │
│ │ │ [Pie Chart]                │ │ [Bar Chart]            │ │
│ │ │ Thue Can Ho: 85%           │ │                        │ │
│ │ │ Dat Coc: 12%               │ │ Van Hanh: 100T         │ │
│ │ │ Dich Vu: 3%                │ │ Bao Tri: 50T           │ │
│ │ │                            │ │ Nhan Su: 30T           │ │
│ │ └────────────────────────────┘ └────────────────────────┘ │
│ │                                                             │
│ │ ┌────────────────────────────┐ ┌────────────────────────┐ │
│ │ │ Xu Hướng 6 Tháng           │ │ So Sánh Năm Trước      │ │
│ │ │ [Line Chart]               │ │ [Bar Chart]            │ │
│ │ │ Tính từ 01-01 đến 30-06    │ │ 2026 vs 2025           │ │
│ │ │                            │ │                        │ │
│ │ └────────────────────────────┘ └────────────────────────┘ │
│ └─────────────────────────────────────────────────────────────┘ │
│                                                               │
└─────────────────────────────────────────────────────────────┘
```

---

## Danh Sách Components

### 1. Layout Components
- `AppLayout` - Main layout with Sidebar + Navbar + Content
- `Sidebar` - Collapsible navigation menu
- `Navbar` - Top navigation bar
- `Breadcrumb` - Navigation breadcrumb
- `PageHeader` - Page title + actions

### 2. Card Components
- `StatCard` - KPI statistics card (số, tiêu đề, trend)
- `InfoCard` - Info display card
- `PropertyCard` - Căn hộ/property card (card view)
- `TimelineCard` - Hợp đồng timeline

### 3. Table Components
- `DataTable` - Sortable, paginated table
- `TableRow` - Table row with actions
- `ActionButtons` - Xem/Sửa/Xóa/Chi tiết buttons
- `TableFilter` - Filter & search bar
- `TableToolbar` - Toolbar with bulk actions

### 4. Form Components
- `FormField` - Input field wrapper
- `FormSelect` - Dropdown select
- `FormCheckbox` - Checkbox
- `FormRadio` - Radio button
- `FormTextarea` - Textarea
- `FormGroup` - Field group
- `FormModal` - Form in modal dialog
- `FormSubmit` - Submit button

### 5. Chart Components
- `LineChart` - Line chart (Doanh thu xu hướng)
- `BarChart` - Bar chart (So sánh)
- `DoughnutChart` / `PieChart` - Tỷ lệ (căn hộ, HĐ)
- `ChartContainer` - Chart wrapper

### 6. Modal/Dialog Components
- `Modal` - Generic modal
- `ConfirmDialog` - Delete/confirm dialog
- `FormModal` - Form in modal
- `DetailModal` - Chi tiết modal

### 7. Alert/Notification Components
- `Alert` - Alert message (success, error, warning)
- `Toast` - Floating notification
- `Badge` - Status badge (Trống, Đang Thuê, etc)
- `StatusTag` - Status tag (HieuLuc, HetHan, etc)

### 8. Navigation Components
- `MainNav` - Main sidebar navigation
- `NavItem` - Navigation item
- `NavSubmenu` - Submenu

### 9. Input/Search Components
- `SearchBar` - Global search
- `MultiSelect` - Multi-select dropdown
- `DatePicker` - Date selection
- `DateRangePicker` - Date range selection
- `FilterPanel` - Filter UI

### 10. Floor Plan Components
- `FloorPlan` - Sơ đồ tầng
- `ApartmentUnit` - Unit in floor plan
- `FloorSelector` - Select floor
- `BuildingSelector` - Select building

### 11. Profile Components
- `Avatar` - User/customer avatar
- `Profile` - Profile card
- `ProfileInfo` - Profile information

### 12. Timeline Components
- `Timeline` - Timeline view
- `TimelineStep` - Timeline step
- `TimelineStatus` - Status in timeline

### 13. Utility Components
- `Loading` - Loading spinner
- `EmptyState` - Empty state message
- `Pagination` - Pagination control
- `Tooltip` - Tooltip
- `Dropdown` - Dropdown menu

---

## Thiết Kế Dashboard

### Dashboard Layout Structure

```
┌─ Header ─────────────────────────────────────────────────────┐
│ Welcome, [User]! Here's what's happening today              │
└──────────────────────────────────────────────────────────────┘

┌─ KPI Section (Grid 3x4) ──────────────────────────────────────┐
│                                                               │
│ [Card 1]      [Card 2]       [Card 3]                        │
│ [Card 4]      [Card 5]       [Card 6]                        │
│ [Card 7]      [Card 8]       [Card 9]                        │
│ [Card 10]     [Card 11]                                      │
│                                                               │
└──────────────────────────────────────────────────────────────┘

┌─ Charts Section (Grid 2x2) ───────────────────────────────────┐
│                                                               │
│ [Chart 1 - Line]           [Chart 2 - Bar]                  │
│ [Chart 3 - Donut]          [Chart 4 - Donut]                │
│                                                               │
└──────────────────────────────────────────────────────────────┘

┌─ Tables Section ──────────────────────────────────────────────┐
│                                                               │
│ [Table 1 - Recent Invoices]                                 │
│ [Table 2 - Upcoming Contracts]                              │
│ [Table 3 - New Customers]                                   │
│                                                               │
└──────────────────────────────────────────────────────────────┘
```

### KPI Cards Details

```
Card Design:

┌──────────────────────────────┐
│ ┌────────────────────────────┐│
│ │ Icon  Tiêu Đề Card         ││
│ │                            ││
│ │ Số Liệu Lớn               ││
│ │ (Font Size: 32px)         ││
│ │                            ││
│ │ Mô Tả / Trend             ││
│ │ ↑ 5% từ tháng trước       ││
│ └────────────────────────────┘│
└──────────────────────────────┘

Color Coding:
- Xanh: Positive trend (Tăng)
- Đỏ: Negative trend (Giảm)
- Xám: Neutral
```

### Card 1: Tổng Số Khu Vực
```
Icon: 🏢
Title: Khu Vực
Value: 25
Subtitle: +5 từ tháng trước
Trend: ↑ 25% YoY
Color: Primary Blue
```

### Card 2: Tổng Số Tòa Nhà
```
Icon: 🏗️
Title: Tòa Nhà
Value: 180
Subtitle: +15 từ tháng trước
Trend: ↑ 9% YoY
Color: Primary Blue
```

### Card 3: Tổng Số Căn Hộ
```
Icon: 🏠
Title: Căn Hộ
Value: 1,250
Subtitle: +50 từ tháng trước
Trend: ↑ 4% YoY
Color: Primary Blue
```

### Card 4: Căn Hộ Đang Thuê
```
Icon: ✅
Title: Đang Thuê
Value: 850
Subtitle: (68% chiếm dụng)
Trend: ↑ 3% từ tháng trước
Color: Green
```

### Card 5: Căn Hộ Trống
```
Icon: 🔓
Title: Trống
Value: 200
Subtitle: (16% có sẵn)
Trend: ↓ 2% từ tháng trước
Color: Orange
```

### Card 6: Tổng Khách Hàng
```
Icon: 👥
Title: Khách Hàng
Value: 620
Subtitle: +10 khách mới
Trend: ↑ 2% YoY
Color: Purple
```

### Card 7: Hợp Đồng Hiệu Lực
```
Icon: 📋
Title: HĐ Hiệu Lực
Value: 750
Subtitle: Đang hoạt động
Trend: ↑ 5% từ tháng trước
Color: Blue
```

### Card 8: Hóa Đơn Chưa TT
```
Icon: ⚠️
Title: HĐ Chưa TT
Value: 45
Subtitle: 250 Triệu đ
Trend: ↓ 8% từ tháng trước
Color: Red
```

### Card 9: Doanh Thu Tháng
```
Icon: 💵
Title: Doanh Thu
Value: 850 Triệu đ
Subtitle: Tháng 6/2026
Trend: ↑ 12% từ tháng trước
Color: Green
```

### Card 10: Chi Phí Tháng
```
Icon: 💸
Title: Chi Phí
Value: 180 Triệu đ
Subtitle: Tháng 6/2026
Trend: ↓ 3% từ tháng trước
Color: Orange
```

### Card 11: Lợi Nhuận Tháng
```
Icon: 📈
Title: Lợi Nhuận
Value: 670 Triệu đ
Subtitle: Tháng 6/2026
Trend: ↑ 18% từ tháng trước
Color: Green
```

---

## CRUD Design Patterns

### Pattern 1: DataTable CRUD

**Danh Sách:**
- DataTable with columns, sorting, filtering, pagination
- Toolbar: Add, Filter, Export, Bulk Actions
- Row Actions: Edit, Delete, View Details

**Thêm/Sửa:**
- Modal Form hoặc Page riêng
- Form fields with validation
- Submit / Cancel buttons

**Xóa:**
- Confirm dialog
- Soft delete (ẩn) hoặc hard delete
- Success message

**Chi Tiết:**
- Detail view modal hoặc page
- Info sections
- Related data tabs
- Action buttons

### Pattern 2: Card + DataTable CRUD (Căn Hộ)

**View Options:**
- Grid (Card view) / List (Table view) toggle
- Floor Plan view option

**Filter & Search:**
- Multi-criteria filter (Tòa, Tầng, Trạng Thái)
- Quick search

**Card Actions:**
- Click card → Chi tiết modal
- Inline Edit button
- Inline Delete button with confirmation

### Pattern 3: Master-Detail CRUD (Khách Hàng)

**Master (Danh Sách):**
- DataTable of customers
- Avatar thumbnail

**Detail Page:**
- Tabs: Thông tin cá nhân, Hợp Đồng, Hóa Đơn, Lịch Sử TT
- Edit button
- Delete button with confirmation

### Pattern 4: Timeline CRUD (Hợp Đồng)

**List:**
- DataTable with status color
- Quick filters

**Detail:**
- Header with basic info
- Timeline visualization of contract lifecycle
- Related tables (Hóa Đơn)
- Action buttons (Extend, Cancel, etc.)

---

## Đề Xuất UX/UI Tối Ưu

### Cho Người Quản Lý Nhiều Tòa Nhà & Hàng Trăm Căn Hộ

#### 1. Hierarchical Navigation
```
Problem: Nhiều tòa nhà, nhiều căn hộ → dễ lạc
Solution:
- Sidebar cho module chính
- Breadcrumb cho vị trí hiện tại
- Dropdown khu vực/tòa nhà trên top (context switcher)
```

#### 2. Advanced Filtering
```
Problem: Tìm căn hộ cụ thể trong 1000+ căn hộ
Solution:
- Multi-select filters
- Saved filter presets (VD: "Căn hộ trống tòa A")
- Quick search by code/customer name
- Filter by status color
```

#### 3. Dashboard Customization
```
Problem: Mỗi người quản lý quan tâm metric khác
Solution:
- Draggable dashboard widgets
- Widget configuration (add/remove)
- Preset dashboards for different roles
- Save custom view per user
```

#### 4. Bulk Operations
```
Problem: Cập nhật giá thuê 100 căn hộ một lần
Solution:
- Checkbox select all
- Bulk edit modal
- Bulk status change
- Bulk delete with confirmation
```

#### 5. Floor Plan Visualization
```
Problem: Quản lý 20 tầng x 30 tòa nhà
Solution:
- Interactive floor plan
- Color-coded units (Trống/Thuê/Bảo Trì)
- Click unit → chi tiết modal
- Floor/Building selector
- Occupancy stats per floor
```

#### 6. Smart Notifications & Alerts
```
Problem: Dễ quên các sự kiện quan trọng
Solution:
- Dashboard alerts widget (top 5)
- Alert bell in navbar
- Notification priority levels
- Dismiss/Mark as read
- Alert history
```

#### 7. Quick Actions Widget
```
Problem: Thao tác thường xuyên (Mark paid, Extend contract)
Solution:
- Quick action buttons on dashboard
- Keyboard shortcuts (VD: Ctrl+N = New)
- Command palette (Cmd/Ctrl+K)
```

#### 8. Mobile-Responsive Design
```
Problem: Quản lý khi đi họp, khách hàng
Solution:
- Responsive layout (Mobile first)
- Touch-friendly buttons (min 44x44px)
- Mobile-optimized forms
- Progressive Web App (offline support)
```

#### 9. Performance Optimization
```
Problem: Load 1000+ records bị lag
Solution:
- Virtual scrolling (DataTable)
- Pagination with pre-loading
- Lazy loading for chart data
- Caching
- Debounced search
```

#### 10. Audit Trail & History
```
Problem: Không biết ai thay đổi gì
Solution:
- Activity log tab in detail pages
- User + timestamp on each change
- Undo/Revert action button
```

---

## Color Scheme & Styling

### Primary Colors
```
Primary Blue:      #0066CC (Chính, Actions)
Success Green:     #28A745 (Trống, Đã TT)
Warning Orange:    #FFC107 (Cảnh báo, Bảo Trì)
Danger Red:        #DC3545 (Lỗi, Quá hạn)
Info Cyan:         #17A2B8 (Thông tin)
Secondary Gray:    #6C757D (Neutral, Inactive)

Background:
Light Gray:        #F8F9FA (Page bg)
White:             #FFFFFF (Card bg)
Dark Gray:         #343A40 (Text primary)
Light Text:        #6C757D (Text secondary)
```

### Status Colors

```
Căn Hộ:
✅ Trống:         #28A745 (Green)
⏳ Đang Thuê:     #0066CC (Blue)
🔧 Bảo Trì:      #DC3545 (Red)

Hóa Đơn:
✅ Đã Thanh Toán: #28A745 (Green)
⏳ Chưa TT:       #FFC107 (Orange)
⚠️ Quá Hạn:      #DC3545 (Red)
❌ Hủy Bỏ:       #6C757D (Gray)

Hợp Đồng:
✅ Hiệu Lực:      #28A745 (Green)
⏳ Hết Hạn:       #FFC107 (Orange)
❌ Hủy Bỏ:       #DC3545 (Red)
🔄 Gia Hạn:      #0066CC (Blue)
```

### Typography

```
Heading 1:  Font-size: 32px, Font-weight: 700
Heading 2:  Font-size: 24px, Font-weight: 700
Heading 3:  Font-size: 20px, Font-weight: 600
Body:       Font-size: 14px, Font-weight: 400
Small:      Font-size: 12px, Font-weight: 400
Label:      Font-size: 13px, Font-weight: 600

Font-family: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto
```

### Spacing

```
xs: 4px
sm: 8px
md: 16px
lg: 24px
xl: 32px
2xl: 48px
```

### Border Radius

```
sm: 4px (inputs, buttons)
md: 8px (cards, modals)
lg: 12px (larger elements)
```

---

## Technology Stack & Architecture

### Frontend
- **Framework**: Laravel Blade + Vue.js 3 (Optional)
- **CSS Framework**: Bootstrap 5 + Custom CSS/SCSS
- **UI Components**: 
  - DataTables.net (Tables)
  - Chart.js (Charts)
  - Flatpickr (Date Picker)
  - SweetAlert2 (Alerts)
  - Leaflet (Maps, if needed)

### Icons
- **Font Awesome 6** Pro (for professional icons)

### Utilities
- **Responsive Grid**: Bootstrap 5 Grid System
- **Forms**: Bootstrap 5 Forms + Custom validation

### Build Tools
- **Vite** (for asset bundling)
- **SCSS** (for styling)
- **Alpine.js** (for lightweight interactivity)

---

## File Structure Recommendation

```
resources/
├── views/
│   ├── layouts/
│   │   ├── app.blade.php (Main layout)
│   │   ├── sidebar.blade.php
│   │   └── navbar.blade.php
│   │
│   ├── dashboard/
│   │   └── index.blade.php
│   │
│   ├── areas/
│   │   ├── index.blade.php (List)
│   │   ├── create.blade.php (Add)
│   │   ├── edit.blade.php (Edit)
│   │   └── show.blade.php (Detail)
│   │
│   ├── buildings/
│   │   └── ... (similar structure)
│   │
│   ├── apartments/
│   │   ├── index.blade.php (with card view)
│   │   ├── floor-plan.blade.php
│   │   └── ... (CRUD views)
│   │
│   ├── customers/
│   │   └── ... (CRUD views + profile)
│   │
│   ├── contracts/
│   │   ├── index.blade.php
│   │   └── show.blade.php (with timeline)
│   │
│   ├── invoices/
│   │   └── ... (CRUD views)
│   │
│   ├── transactions/
│   │   └── ... (CRUD views)
│   │
│   ├── reports/
│   │   ├── monthly.blade.php
│   │   ├── quarterly.blade.php
│   │   └── yearly.blade.php
│   │
│   ├── system/
│   │   ├── users.blade.php
│   │   ├── roles.blade.php
│   │   └── settings.blade.php
│   │
│   └── components/
│       ├── stat-card.blade.php
│       ├── data-table.blade.php
│       ├── form-modal.blade.php
│       └── ... (other reusable components)
│
├── css/
│   ├── app.css (imports bootstrap + custom)
│   └── custom.scss
│
└── js/
    ├── app.js
    └── components/
        └── ... (Vue components if used)
```

---

## Implementation Phases

### Phase 1: Foundation (Week 1-2)
- ✅ Setup layout (Sidebar, Navbar, Main Layout)
- ✅ Dashboard skeleton
- ✅ Breadcrumb + Navigation
- ✅ Color scheme + Typography

### Phase 2: CRUD Modules (Week 3-4)
- ✅ Khu Vực CRUD
- ✅ Tòa Nhà CRUD
- ✅ Căn Hộ CRUD + Floor Plan
- ✅ Khách Hàng CRUD

### Phase 3: Complex Modules (Week 5-6)
- ✅ Hợp Đồng CRUD + Timeline
- ✅ Hóa Đơn CRUD
- ✅ Thu Chi CRUD

### Phase 4: Analytics & Reports (Week 7)
- ✅ Báo Cáo Tài Chính
- ✅ Dashboard Charts

### Phase 5: System Features (Week 8)
- ✅ Tài Khoản người dùng
- ✅ Phân quyền
- ✅ Cài đặt

### Phase 6: Polish & Optimization (Week 9-10)
- ✅ Mobile responsive
- ✅ Performance optimization
- ✅ Testing & QA
- ✅ Documentation

---

## Best Practices for This System

### 1. Consistency
- Use same component patterns across all modules
- Consistent naming conventions
- Consistent color usage for status

### 2. Performance
- Lazy load heavy components (charts)
- Paginate large tables
- Cache frequently used data

### 3. Accessibility
- Proper ARIA labels
- Keyboard navigation support
- Color contrast compliance

### 4. User Experience
- Clear error messages
- Success confirmations
- Undo functionality where possible
- Inline help/tooltips

### 5. Responsiveness
- Mobile-first design
- Test on multiple devices
- Touch-friendly elements

---

**End of Document**

---

## Notes
- All mockups are ASCII-based for simplicity
- Can be replaced with actual design tools (Figma, Adobe XD)
- Component library can be built with Bootstrap utilities + custom Vue/Alpine components
- All colors referenced are web-safe and accessible
