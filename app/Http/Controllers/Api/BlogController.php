<?php

namespace App\Http\Controllers\Api;

use App\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Vedmant\FeedReader\Facades\FeedReader;

class BlogController extends Controller
{
    public function dummy()
    {
        $titles = array(
            "🌟 ZERO SPIRIT | CHẤP NHẬN HỌC HỎI VÀ ĐƯƠNG ĐẦU NHỮNG THỬ THÁCH MỚI🌟", "🌟 ZERO SPIRIT | CHẤP NHẬN HỌC HỎI VÀ ĐƯƠNG ĐẦU NHỮNG THỬ THÁCH MỚI🌟", "GHTK BỔ SUNG DỊCH VỤ MỚI: GÓI SIÊU RẺ GIẢM GIÁ LÊN TỚI 50% SO VỚI BIỂU PHÍ NIÊM YẾT", "☀ GHTK’s Care | LUÔN CÓ NHÀ KIỆM CẠNH BÊN ☀", "GHTK’s Care | CÙNG NHAU LAN TỎA YÊU THƯƠNG 🌼", "GHTK’s Care | Mỗi đóng góp là một sự sẻ chia", "GHTK’s Care | Câu chuyện đẹp từ người con chăm chỉ", "❤ GHTK’s Care | Mạnh mẽ lên Phát nhé, có anh em đợi! ❤", "GHTK’s Care | Sức mạnh của tình yêu thương nhà Kiệm", "GHTK’s Care | Hành động nhỏ ý nghĩa lớn", "💚GHTK’s Care | Tình yêu thương nhà Kiệm vượt lên tất cả💚", "❤ GHTK’s Care | “Anh sẽ trở lại sớm thôi” ❤", "🏆🏆🏆 CUỘC THI CÙNG NHAU – DÀNH CHO CON: CÔNG BỐ GIẢI ĐẶC BIỆT 🌟🌟🌟", "🎉🎉🎉 CÙNG NHAU – DÀNH CHO CON: CÔNG BỐ TOP 05 GIA ĐÌNH ĐẠT GIẢI ẤN TƯỢNG 🎁🎁🎁", "🔔🔔🔔SỐ LƯỢNG BÀI THI VƯỢT MỐC 100, HƠN 1000 QUẢ TIM PHỦ SÓNG APP NỘI BỘ❤️❤️❤️", "CUỘC THI ️”CÙNG NHAU – DÀNH CHO CON️”", "ĐỒNG GIÁ 16K CHO ĐƠN HÀNG XFAST – GIAO HÀNG NỘI THÀNH CHỈ 2H TRONG THÁNG 6", "DEAL KHỦNG SIÊU HỜI DÀNH CHO CÁC SHOP BÁN HÀNG CHUYÊN NGHIỆP: FREE HOÀN VÀ CAM KẾT TỶ LỆ HOÀN KHI ĐĂNG ĐƠN QUA MOSHOP", "ĐỒNG GIÁ 10K CHO SHOP MỚI ĐĂNG KÝ TRONG THÁNG 6", " ZERO SPIRIT | NHÂN SỰ KHO LV YÊN NGHĨA – TÔ TRẦN THẠCH THẢO: “CÔ NÀNG KẸO NGỌT” TỰ DẶN MÌNH NHANH LỚN ĐỂ VỀ NHÀ! ", "💎ZERO SPIRIT💎 | BỘ 3 SALES – CSKH – COD LẤY NHÀ KIỆM: CÙNG NHAU TẠO NÊN NIỀM TIN NƠI SHOP🌿", "🌟 ZERO SPIRIT | ANH ĐIỀU PHỐI HẾT LÒNG VÌ CÔNG VIỆC VÀ NIỀM ĐAM MÊ VỚI HÀNG HÓA 🌟", " 🌟 ZERO SPIRIT | THAY ĐỔI, CHÚ TÂM HƠN VÀO CÔNG VIỆC ĐỂ ĐẠT HIỆU QUẢ TỐT NHẤT 🌟", "🌟ZERO SPIRIT | NỖ LỰC CỐ GẮNG, CHÚ Ý HỌC HỎI ĐỂ THÀNH CÔNG 🌟", "2✨NGÔI SAO THÁNG 4 | CÁ NHÂN XUẤT SẮC KHỐI VĂN PHÒNG/VẬN HÀNH✨", "NGÔI SAO THÁNG 4/2020 | TẬP THỂ VẬN HÀNH XUẤT SẮC THÁNG 4 ☀", "✨ ZERO SPIRIT | NÚI NON, ĐƯỜNG ĐẤT KHÔNG NGĂN ĐƯỢC CHÚNG TA ✨", "✨ ZERO SPIRIT | “BÔNG HỒNG GAI” CỦA BƯU CỤC THÁI NGUYÊN ✨", "⚡ ZERO SPIRIT⚡ | “TỰ BƠI” SẼ CHO MÌNH NHIỀU BÀI HỌC, BIẾT ĐƯỢC NHIỀU THỨ MỚI MẺ HƠN", "⚡ ZERO SPIRIT | CÙNG VỚI KHÓ KHĂN SẼ LÀ NHỮNG ĐIỀU ĐÁNG TRÂN QUÝ ⚡", "⚡⚡ ZERO SPIRIT | NGƯỜI “CHỊ CẢ” LỠ “NGÃ” VÀO NHÀ KIỆM ❤", "🌟 ZERO SPIRIT | PHẤN ĐẤU HOÀN THIỆN BẢN THÂN ĐỂ CHINH PHỤC THỬ THÁCH 🌟", "XFAST 2H – NHANH CHÓNG, TIỆN LỢI VÀ NHIỀU HƠN THẾ NỮA, SHOP ĐÃ THỬ CHƯA?", "🌟 ZERO SPIRIT | CHUYẾN ĐI MỚI TẠO NÊN NHỮNG ĐIỀU ĐÁNG QUÝ🌟", "💖ZERO SPIRIT💖 | PHÁP CHẾ NGUYỄN THỊ LÀNH: TUỔI TRẺ VỚI ƯỚC MƠ CỐNG HIẾN VÀ TÌNH YÊU", "DEAL HOT THÁNG 5 –  GIẢM 10% PHÍ GIAO HÀNG DÀNH CHO CÁC SHOP BÁN HÀNG CHUYÊN NGHIỆP", "THÁNG 5 TIẾP TỤC FREE HOÀN 100% KHI ĐĂNG ĐƠN QUA MOSHOP", "CÁCH NGƯỜI NHÀ KIỆM CHÚNG TA VƯỢT QUA NHỮNG KHÓ KHĂN", "GHTK’s Care | Dù có cách xa nơi đâu Kiệm vẫn chan chứa tình yêu thương.", "GHTK’s Care | Tình yêu thương là mãi mãi với nhà Kiệm.", "moshop – PHẦN MỀM QUẢN LÝ BÁN HÀNG MIỄN PHÍ CỦA NHÀ KIỆM", "GHTK RA MẮT DỊCH VỤ XFAST: LẤY VÀ GIAO NỘI THÀNH CHỈ TRONG 2H", "GHTK RA MẮT DỊCH VỤ MỚI: GÓI TIẾT KIỆM SIÊU RẺ", "🌟 ZERO SPIRIT | THAY ĐỔI, CHÚ TÂM HƠN VÀO CÔNG VIỆC ĐỂ ĐẠT HIỆU QUẢ TỐT NHẤT 🌟", "THƯỞNG NÓNG F STAR THÁNG 04/2020", "💎ZERO SPIRIT | BEST SALES THÁNG 3 – BÙI THỊ THU PHƯƠNG: TƯ DUY ĐỔI MỚI ĐỂ BỨT PHÁ!💎", "04|2013 – 04|2020 GHTK 7+", "🌟 ZERO SPIRIT | LÀM TRÁI NGÀNH KHÔNG CÓ GÌ LÀ KHÓ 🌟", "🌟 ZERO SPIRIT | TINH THẦN HỌC HỎI, DÁM THAY ĐỔI CỦA NGƯỜI MỚI 🌟", "💚GHTK’s Care | Corona không làm xa cách tình yêu thương nhà Kiệm.", "☀️ZERO SPIRIT | Hậu phương vững chắc của các anh lái xe nhà Kiệm🚛🚛🚛", "ZERO SPIRIT | “CÔ GÁI VÀNG TRONG LÀNG HỖ TRỢ”", "🥇ZERO SPIRIT | THAY ĐỔI, THÍCH NGHI VÀ TẬN TÂM PHỤC VỤ️🥇", "👏 ZERO SPIRIT| Ý CHÍ KIÊN CƯỜNG TẠO NÊN KỲ TÍCH 👏", "⚡ ZERO SPIRIT| TÂM MÌNH NƠI ĐÂU THÀNH CÔNG TẠI ĐÓ ⚡", "⭐NGÔI SAO THÁNG 3⭐ KHỐI VĂN PHÒNG/VẬN HÀNH PHẦN 2", "⭐NGÔI SAO THÁNG 3⭐.", "🏆VINH DANH COD XUẤT SẮC THÁNG 3/2020🏆", "GHTK’s Care | Corona không làm xa cách tình yêu thương nhà Kiệm với COD Cao Quốc Ân", "🏅ZERO SPIRIT | NGƯỜI ANH CẢ VÀ HAI CHỮ “TRÁCH NHIỆM”", "VINH DANH CÁC GIẢI F-AWARDS TRIỂN VỌNG – KHU VỰC MIỀN BẮC", "GHTK’s Care | Tấm lòng của anh em cả nước dành cho COD Trần Văn Mạnh", "GHTK’S CARE | Tinh thần kiên cường vượt lên tất cả của COD Nguyễn Văn Bảo", "SIÊU ƯU ĐÃI MÙA DỊCH – GỬI HÀNG HUYỆN XÃ RẺ NHƯ TRUNG TÂM TRÊN MOSHOP", "GHTK ĐỒNG HÀNH CÙNG CÁC SHOP BÁN HÀNG CHUYÊN NGHIỆP: FREE HOÀN 100% KHI ĐĂNG ĐƠN QUA MOSHOP", "ZERO SPIRIT| HỌC MỚI VÀ BẮT ĐẦU LẠI TỪ ĐẦU – THÀNH CÔNG VẪN SẼ TỚI NẾU BẠN DÁM THAY ĐỔI", "🏅Zero Spirit | Những phút trải lòng phía sau tay lái 💬", "Công ty cổ phần Giao Hàng Tiết Kiệm ủng hộ công tác phòng chống dịch COVID-19", "ZERO SPIRIT| GỘP KHỐI NHÂN SỰ – THAY ĐỔI ĐEM LẠI CƠ HỘI MỚI CHO TỪNG CÁ NHÂN", "🌼ZERO SPIRIT | COD NGUYỄN VĂN TỒN – KHO THỊ MỘT – AN GIANG 🌼", "[GHTK’s CARE] “Sự quan tâm của anh em qua quỹ GHTK’s Care là động lực để anh nỗ lực hơn!”", "[GHTK’Ss CARE] Câu chuyện đẹp giữa mùa dịch bệnh", "CÁCH GIÚP “ĐỨC ĐEN” LUÔN THUỘC TOP ĐẦU HIỆU QUẢ CÔNG VIỆC KHO NGÔ MÂY – SÁNG TẠO VÀ ĐỔI MỚI KHÔNG NGỪNG", "Nhạy bén và không ngại làm mới bản thân – đó là cách Ngôi sao tháng 2 xuất sắc ghi danh bảng vàng sau 6 tháng làm việc", "KHEN THƯỞNG COD XUẤT SẮC – THÁNG 2/2020 (KHU VỰC TP. HCM &amp; MIỀN TRUNG)", "ZERO SPIRIT | THAY ĐỔI ĐỂ TRƯỞNG THÀNH, ĐỂ MẠNH MẼ VƯỢT KHÓ KHĂN", "Hướng dẫn cách cài đặt Đối soát trên hệ thống GHTK", "VINH DANH CÁC GIẢI F-AWARDS – KHU VỰC MIỀN BẮC", "ZERO SPIRIT | VẬN HÀNH TỈNH CHIA SẺ VỀ NHỮNG THAY ĐỔI TRONG CÔNG VIỆC NĂM QUA Ở CÁC TỈNH", "ZERO SPIRIT | VẬN HÀNH CHIA SẺ THAY ĐỔI VỀ CÔNG VIỆC NĂM QUA", "BÀI DỰ THI KHOẢNH KHẮC THANH XUÂN – Nguyễn Ngọc Minh", "BÀI DỰ THI KHOẢNH KHẮC THANH XUÂN – Nguyễn Huỳnh Sơn", "BÀI DỰ THI KHOẢNH KHẮC THANH XUÂN –  Nguyễn Văn Quyết", "BÀI DỰ THI KHOẢNH KHẮC THANH XUÂN – Nguyễn Thành Sự", "BÀI DỰ THI KHOẢNH KHẮC THANH XUÂN – Phạm Hồng Thủy", "BÀI DỰ THI KHOẢNH KHẮC THANH XUÂN – Nguyễn Thị Mến", "🔥🔥🔥 Tự đăng bài KHOẢNH KHẮC THANH XUÂN trên App nội bộ", "🎁 GIẢI THƯỞNG SIÊU TO KHỔNG LỒ TỪ “KHOẢNH KHẮC THANH XUÂN”", "💕💕 CUỘC THI ẢNH KHOẢNH KHẮC THANH XUÂN", "💚Quỹ GHTK’s Care COD Nguyễn Trường Hận | Hành động từ trái tim sẽ chạm đến trái tim✨✨✨", "🌻F-AWARD | LEADER TRIỂN VỌNG VÀ LEADER XUẤT SẮC KHU VỰC MIỀN NAM, MIỀN TRUNG VÀ MIỀN BẮC🌻", "🌼ZERO SPIRIT | Người chiến thắng là người không bao giờ ngừng cố gắng🌼", "GHTK BỔ SUNG KÊNH GIẢI ĐÁP VÀ TRAO ĐỔI THÔNG TIN CHO KHÁCH HÀNG: 1001 HỎI ĐÁP VÀ TÂM SỰ GIAO HÀNG.", "💓[BÀN TAY VÀNG – BÀN TAY VÀNG TRIỂN VỌNG – VÔ LĂNG VÀNG – VÔ LĂNG VÀNG TRIỂN VỌNG – F-FIGHTER – F-FIGHTER TRIỂN VỌNG]💓", "ĐẠI SỨ BẢN SẮC 2020 – KHU VỰC MIỀN BẮC", "ZERO SPIRIT | BIẾN NỖI SỢ THÀNH NIỀM TIN VƯỢT MỌI THÁCH THỨC MỚI LÀ TINH THẦN ZERO SPIRIT", "BÁN HÀNG VI VU – TIỀN VỀ VÙ VÙ : TẤT TẦN TẬT VỀ ĐỐI SOÁT – CHUYỂN TIỀN THU HỘ GHTK", "ĐỒNG HÀNH CÙNG CÁC SHOP BÁN HÀNG CHUYÊN NGHIỆP: GHTK CAM KẾT TỶ LỆ HOÀN 1%", "LEADER UNDER 25 2020 – FINDING Z LEADER"
        );
        $images = scandir('C:\xampp\htdocs\blog\back-end\public\images');
        for ($i = 0; $i < 1000; $i++) {
            $blog = new Blog();
            $blog->title = $titles[rand(0, count($titles)-1)];
            $blog->user_id = 1;
            $blog->cat_id = rand(1, 5);
            $blog->thumbnail = "http://localhost:8000/images/".$images[rand(0, count($images)-1)];
            //$blog->slug = "bai-viet-so-" . ($i + 1);
            $blog->description = "Theo hội nghị Digiday Content Marketing vào đầu năm 2016, một trong những khó khăn lớn nhất mà các content marketer đang gặp phải là thiếu hụt về kinh phí. Các chiến dịch content marketing thường khó thu hút kinh phí hơn so với các hình thức marketing khác, vốn thường mang lại lợi nhuận chỉ sau một thời gian ngắn.";
            $content = "";
            for ($x = 0; $x < rand(2, 7); $x++) {
                $content .= "Theo hội nghị Digiday Content Marketing vào đầu năm 2016, một trong những khó khăn lớn nhất mà các content marketer đang gặp phải là thiếu hụt về kinh phí. Các chiến dịch content marketing thường khó thu hút kinh phí hơn so với các hình thức marketing khác, vốn thường mang lại lợi nhuận chỉ sau một thời gian ngắn. ";
            }
            $blog->content = $content;
            $blog->save();
        }
        exit();
    }

    public function index()
    {

        /*
        for($i = 0; $i < 1000; $i++) {
            $blog = new Blog();
            $blog->title = "Bài viết số với một cái tên dài ".($i+1);
            $blog->user_id = 1;
            $blog->thumbnail = "https://picsum.photos/600/400";
            $blog->slug = "bai-viet-so-".($i+1);
            $blog->description = "Theo hội nghị Digiday Content Marketing vào đầu năm 2016, một trong những khó khăn lớn nhất mà các content marketer đang gặp phải là thiếu hụt về kinh phí. Các chiến dịch content marketing thường khó thu hút kinh phí hơn so với các hình thức marketing khác, vốn thường mang lại lợi nhuận chỉ sau một thời gian ngắn.";
            $content = "";
            for($x = 0; $x < rand(2, 7); $x++) {
                $content .=  "Theo hội nghị Digiday Content Marketing vào đầu năm 2016, một trong những khó khăn lớn nhất mà các content marketer đang gặp phải là thiếu hụt về kinh phí. Các chiến dịch content marketing thường khó thu hút kinh phí hơn so với các hình thức marketing khác, vốn thường mang lại lợi nhuận chỉ sau một thời gian ngắn. ";
            }
            $blog->content = $content;
            $blog->save();
        }
        exit();
        */
        $perPage = request('per_page', 16);
        $blogs = Blog::with('category')->orderBy('id', 'DESC')->paginate($perPage);
        return response()->json($blogs);
    }

    public function getBlogsByCategory($id)
    {
        $perPage = request('per_page', 16);
        if ($id > 0) {
            $blogs = Blog::with('category')->where('cat_id', $id)->orderBy('id', 'DESC')->paginate($perPage);
        } else {
            $blogs = Blog::with('category')->orderBy('id', 'DESC')->paginate($perPage);
        }

        return response()->json($blogs);
    }

    public function show($id) {
        return response()->json(Blog::where('id', $id)->first());
    }
}
