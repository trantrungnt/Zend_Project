-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 06, 2012 at 07:32 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fashion4u`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `adm_id` int(11) NOT NULL AUTO_INCREMENT,
  `adm_usr` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `adm_pwd` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`adm_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adm_id`, `adm_usr`, `adm_pwd`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cat_des` text COLLATE utf8_unicode_ci,
  `url` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`, `cat_des`, `url`) VALUES
(12, 'for men', 'for.men', 'for-men'),
(13, 'for women', 'for women', 'for-women'),
(14, 'for boys', 'for boys', 'for-boys'),
(15, 'for girls', 'for girls', 'for-girls'),
(16, 'for  teen', 'for  teen', 'for--teen');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE IF NOT EXISTS `colors` (
  `col_id` int(11) NOT NULL AUTO_INCREMENT,
  `col_name` varchar(200) NOT NULL,
  PRIMARY KEY (`col_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`col_id`, `col_name`) VALUES
(1, 'red'),
(2, 'blue'),
(3, 'green'),
(4, 'orange'),
(5, 'black'),
(6, 'white'),
(7, 'Purple');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT,
  `com_content` text COLLATE utf8_unicode_ci NOT NULL,
  `cus_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cus_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pro_id` int(11) NOT NULL,
  `date_create` date NOT NULL,
  PRIMARY KEY (`com_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=25 ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`com_id`, `com_content`, `cus_email`, `cus_name`, `pro_id`, `date_create`) VALUES
(19, 'test', 'sonnv@gmail.com', 'sonnv ', 14, '2012-02-04'),
(20, 'test 1', 'hhhhh@gmail.com', 'sonnv', 14, '2012-02-04'),
(21, 'fhihfioashfoiasfsa', 'test@gmail.com', 'sonnv', 14, '2012-02-04'),
(22, 'hhhhhh', 'kkk@gmail.com', 'sonnv', 30, '2012-02-05'),
(23, '1234', 'hhhhh@gmail.com', 'sonnv', 31, '2012-02-06'),
(24, 'fdjgfdfgsdgsd', 'hhh@gmail.com', 'sonnv', 32, '2012-02-07');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `cus_id` int(11) NOT NULL AUTO_INCREMENT,
  `cus_avatar` text NOT NULL,
  `cus_pass` text NOT NULL,
  `cus_email` varchar(100) NOT NULL,
  `cus_name` varchar(200) NOT NULL,
  `cus_phone` text NOT NULL,
  `cus_address` varchar(200) NOT NULL,
  PRIMARY KEY (`cus_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cus_id`, `cus_avatar`, `cus_pass`, `cus_email`, `cus_name`, `cus_phone`, `cus_address`) VALUES
(2, '', 'e10adc3949ba59abbe56e057f20f883e', 'aaa@gmail.com', 'hhh', '454353454', '5tegdgd'),
(3, 'no_avatar.png', '', 'fdfdfd@hhh.com', 'iodshfs', '4423423', 'sadsadasd'),
(4, '', '18b3e721aca564fa9b678679adff6683', 'sonnv@gmail.com', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_product`
--

CREATE TABLE IF NOT EXISTS `gallery_product` (
  `gal_id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_id` int(11) NOT NULL,
  `gal_img` varchar(200) NOT NULL,
  PRIMARY KEY (`gal_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `gallery_product`
--

INSERT INTO `gallery_product` (`gal_id`, `pro_id`, `gal_img`) VALUES
(1, 26, '/app/templates/admin/images/upload/product/1328177146_tulips.jpg'),
(2, 26, '/app/templates/admin/images/upload/product/1328177146_jellyfish.jpg'),
(3, 27, '/app/templates/admin/images/upload/product/1328177204_chrysanthemum.jpg'),
(4, 27, '/app/templates/admin/images/upload/product/1328177204_desert.jpg'),
(5, 27, '/app/templates/admin/images/upload/product/1328177205_hydrangeas.jpg'),
(6, 28, '/app/templates/admin/images/upload/product/1328177413_tulips.jpg'),
(7, 28, '/app/templates/admin/images/upload/product/1328177413_jellyfish.jpg'),
(8, 29, '/app/templates/admin/images/upload/product/1328180280_penguins.jpg'),
(9, 29, '/app/templates/admin/images/upload/product/1328180280_tulips.jpg'),
(10, 33, '/app/templates/admin/images/upload/product/1328259292_img_5809-650x647.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cus_id` int(11) NOT NULL,
  `cus_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cus_type` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `grand_total` int(11) NOT NULL,
  `payment_method` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `order`
--


-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE IF NOT EXISTS `order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `order_item`
--


-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `subcat_id` int(11) NOT NULL,
  `col_id` int(11) NOT NULL,
  `siz_id` int(11) NOT NULL,
  `pro_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `pro_price` int(20) NOT NULL,
  `pro_quantity` int(11) NOT NULL,
  `pro_img` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `pro_des` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`pro_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=58 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`pro_id`, `subcat_id`, `col_id`, `siz_id`, `pro_name`, `pro_price`, `pro_quantity`, `pro_img`, `pro_des`) VALUES
(30, 14, 2, 1, 'DIESEL INDUSTRY 503', 150, 10, '/app/templates/admin/images/upload/product/1328258282_diesel-503-500x500.jpg', 'thá»i trang'),
(31, 14, 5, 2, 'DIESEL INDUSTRY 511', 170, 7, '/app/templates/admin/images/upload/product/1328258707_diesel-industry-511-500x500.jpg', 'phong cÃ¡ch vÃ  cÃ¡ tinh'),
(32, 14, 5, 3, 'CALVIN KLEIN 663', 200, 15, '/app/templates/admin/images/upload/product/1328258886_calvin-klein-663-500x500.jpg', 'Ä‘Äƒng cáº¥p'),
(33, 15, 5, 1, 'SÆ¡ mi Purple club P510', 300, 20, '/app/templates/admin/images/upload/product/1328259292_so-mi-nam-p10.jpg', 'Kháº³ng Ä‘á»‹nh 100%:\r\n- HÃ¬nh áº£nh nhÆ° tháº¿ nÃ o, Ã¡o á»Ÿ ngoÃ i nhÆ° tháº¿ Ä‘Ã³\r\n- Ão nháº­p nguyÃªn chiáº¿c tá»« HÃ n Quá»‘c'),
(34, 15, 2, 3, 'SÆ¡ mi nam P503', 320, 12, '/app/templates/admin/images/upload/product/1328259453_so-mi-nam-p503.jpg', 'Ão sÆ¡ mi HÃ n Quá»‘c'),
(35, 15, 5, 4, 'So mi Purple Club P795', 380, 18, '/app/templates/admin/images/upload/product/1328259585_so-mi-nam-cong-so-p795_03.jpg', 'Ã¡o sÆ¡ mi HÃ n Quá»‘c'),
(36, 16, 6, 1, 'vnam0139', 700, 8, '/app/templates/admin/images/upload/product/1328260063_eurohomme_13260.jpg', 'vest nam'),
(37, 16, 5, 4, 'vnam0113', 400, 11, '/app/templates/admin/images/upload/product/1328260242_eurohomme_13918.jpg', 'vest nam'),
(38, 16, 3, 3, 'vnam0115', 420, 3, '/app/templates/admin/images/upload/product/1328260345_eurohomme_13901.jpg', 'vest nam'),
(39, 18, 3, 3, 'VÃY V336', 200, 11, '/app/templates/admin/images/upload/product/1328260813_vay-v336-250x250.jpg', 'mang láº¡i cÃ¡ tÃ­nh cho báº¡n'),
(40, 18, 7, 2, 'VÃY V330', 250, 12, '/app/templates/admin/images/upload/product/1328261031_v330-250x250.jpg', 'mÃ u tÃ­m thá»§y chung'),
(41, 18, 1, 1, 'VÃY V257K', 250, 8, '/app/templates/admin/images/upload/product/1328261154_v257k.jpg', 'red'),
(42, 19, 5, 2, 'Quáº§n jean ná»¯ trÆ¡n Ä‘en Boss M12 ', 320, 20, '/app/templates/admin/images/upload/product/1328261469_0000577.jpg', 'Quáº§n jean ná»¯ máº§u Ä‘en viá»n chá»‰ ná»•i khÃ¡c máº§u,má»m, co giÃ£n Ã­t, tÃºi Ä‘á»©ng nhÃ£ nháº·n. '),
(43, 14, 5, 2, 'Quáº§n Jean nam Levis 514 Skinny M1', 350, 16, '/app/templates/admin/images/upload/product/1328371825_fib1322387701.jpg', 'Quáº§n Jean nam Levis 514 Skinny M1'),
(44, 14, 2, 1, 'Quáº§n Jean nam CK Xtreme Skinny BM01', 400, 12, '/app/templates/admin/images/upload/product/1328371938_hsu1318933209.jpg', 'Quáº§n Jean nam CK Xtreme Skinny BM01'),
(45, 14, 5, 4, 'Quáº§n Jean nam A|X BA02', 320, 10, '/app/templates/admin/images/upload/product/1328372042_fdy1323658522.jpg', 'Quáº§n Jean nam A|X BA02'),
(46, 14, 5, 3, 'Quáº§n Jean nam Burberry BB01', 400, 20, '/app/templates/admin/images/upload/product/1328372183_ton1322390015.jpg', 'Quáº§n Jean nam Burberry BB01'),
(47, 15, 1, 2, 'SÆ¡ mi nam cao cáº¥p wizikorea ndo30s', 400, 20, '/app/templates/admin/images/upload/product/1328372436_ndo030s_01_03.jpg', 'SÆ¡ mi nam cao cáº¥p wizikorea ndo30s'),
(48, 15, 5, 3, 'SÆ¡ mi nam Slim Fit SRM8059', 150, 12, '/app/templates/admin/images/upload/product/1328372529_so-mi-nam-slimfit-srm-8059-3_03.jpg', 'SÆ¡ mi nam Slim Fit SRM8059'),
(49, 15, 5, 2, 'Ão sÆ¡ mi nam tráº¯ng EN01(Ä‘áº¹p)', 320, 7, '/app/templates/admin/images/upload/product/1328372689_en-ao-so-mi-nam-trang-01cs_trang_02.jpg', 'Ão sÆ¡ mi nam tráº¯ng EN01(Ä‘áº¹p)'),
(50, 15, 2, 4, 'Ão sÆ¡ mi cao cáº¥p wizikorea ndo20s', 200, 20, '/app/templates/admin/images/upload/product/1328374425_so-mi-nam-cao-cap-ndo020s_01_03.jpg', 'Ão sÆ¡ mi cao cáº¥p wizikorea ndo20s'),
(51, 18, 5, 2, 'Äáº¦M D1546', 150, 12, '/app/templates/admin/images/upload/product/1328374625_dam-d1546.jpg', 'Äáº¦M D1546'),
(52, 18, 5, 3, 'VÃY V257R', 200, 11, '/app/templates/admin/images/upload/product/1328374711_v257r.jpg', 'VÃY V257R'),
(53, 18, 2, 1, 'VÃY V348', 200, 11, '/app/templates/admin/images/upload/product/1328374789_v348.jpg', 'VÃY V348'),
(54, 18, 6, 4, 'VÃY V358', 320, 11, '/app/templates/admin/images/upload/product/1328374875_v358.jpg', 'VÃY V358'),
(55, 19, 2, 3, 'VS Hipster Crop Jean / VSJS8001', 200, 10, '/app/templates/admin/images/upload/product/1328375154_quan-jeans-nu-vs-hipster-crop-jean-vsjs8001.jpg', 'VS Hipster Crop Jean / VSJS8001'),
(56, 19, 2, 4, 'Quáº§n jeans ná»¯ JW002', 320, 10, '/app/templates/admin/images/upload/product/1328375335_quan-jeans-nu-jw002.jpg', 'Quáº§n jeans ná»¯ JW002'),
(57, 19, 5, 1, 'Quáº§n jeans ná»¯ JW003', 400, 20, '/app/templates/admin/images/upload/product/1328375412_quan-jeans-nu-jw003.jpg', 'Quáº§n jeans ná»¯ JW003');

-- --------------------------------------------------------

--
-- Table structure for table `promotion`
--

CREATE TABLE IF NOT EXISTS `promotion` (
  `prom_id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_id` int(11) NOT NULL,
  `prom_des` text COLLATE utf8_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  PRIMARY KEY (`prom_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `promotion`
--


-- --------------------------------------------------------

--
-- Table structure for table `size`
--

CREATE TABLE IF NOT EXISTS `size` (
  `siz_id` int(11) NOT NULL AUTO_INCREMENT,
  `siz_name` varchar(200) NOT NULL,
  PRIMARY KEY (`siz_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `size`
--

INSERT INTO `size` (`siz_id`, `siz_name`) VALUES
(1, 'small'),
(2, 'medium'),
(3, 'large'),
(4, 'extra large');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE IF NOT EXISTS `subcategory` (
  `subcat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `subcat_name` varchar(200) NOT NULL,
  `subcat_des` text NOT NULL,
  `url` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`subcat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`subcat_id`, `cat_id`, `subcat_name`, `subcat_des`, `url`) VALUES
(14, 12, 'Jeans', 'quáº§n bÃ² nam', 'jeans'),
(15, 12, 'shirt', 'Ão sÆ¡ mi nam', 'shirt'),
(16, 12, 'Vest', 'Vest', 'vest'),
(18, 13, 'Skirt', 'vÃ¡y', 'skirt'),
(19, 13, 'Jeans', 'Jeans ná»¯', 'jeans'),
(20, 13, 'Ão sÆ¡ mi', 'Ão sÆ¡ mi ná»¯', 'ão-sæ¡-mi'),
(22, 14, 'Jeans', 'jeans', 'jeans'),
(23, 14, 'Ão phÃ´ng', 'Ã¡o phÃ´ng', 'ão-phã´ng'),
(24, 14, 'Ão sÆ¡ mi', 'Ã¡o sÆ¡ mi', 'ão-sæ¡-mi'),
(26, 15, 'Jeans', 'jeans', 'jeans'),
(27, 15, 'VÃ¡y', 'vÃ¡y', 'vã¡y'),
(28, 15, 'Ão phÃ´ng', 'Ã¡o phÃ´ng', 'ão-phã´ng'),
(29, 15, 'Ão sÆ¡ mi', 'Ã¡o sÆ¡ mi', 'ão-sæ¡-mi'),
(31, 16, 'Jeans', 'jeans', 'jeans'),
(32, 16, 'Ão phÃ´ng', 'Ão phÃ´ng', 'ão-phã´ng'),
(33, 16, 'Ão sÆ¡ mi', 'Ão sÆ¡ mi', 'ão-sæ¡-mi');
