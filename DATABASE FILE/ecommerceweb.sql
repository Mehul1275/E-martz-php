-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2025 at 07:26 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerceweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `company_address` text DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `gstno` varchar(30) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `email_verified` tinyint(1) DEFAULT 0,
  `status` tinyint(4) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`id`, `fullname`, `company_name`, `company_address`, `email`, `phone`, `gstno`, `password`, `token`, `email_verified`, `status`, `created_at`) VALUES
(2, 'nick', 'adidas', 'ahmdabad,gujrat,india', 'nick@gmail.com', '9726331300', '25VWAHS3169B2W8', '$2y$10$FSyqPRS9qwxPtQBxCCtKlOJZyVpwAYyG1GBNfqN.QzfEI8slstPD.', NULL, 1, 1, '2025-07-24 18:44:27'),
(6, 'puma', 'puma', 'amroli', 'puma@gmail.com', '1234567890', '24VWSHS3169C3Z6', '$2y$10$d1XiRScMLzl0J6yXlM/9vOI6PXcSaVoB27SVQ9Sd8h4PwS4GauIFe', '2d17b3b54b1c81a00d373bcd992b122a', 1, 1, '2025-07-27 18:59:11'),
(7, 'zudio', 'zudio', 'amroli', 'zudio@gmail.com', '4444444444', '25VWAHS3169B2W8', '$2y$10$5tQ2l0VViGxYSMdVLO6F5OGtMzG137RfsSjJoOz4anLU//ur4k5U.', '4eeb631288b6844dd36a4d276e4395c1', 1, 1, '2025-07-27 19:08:14'),
(8, 'one8', 'one8', 'amroli', 'one8@mail.com', '1231233454', '25VWAHS3169B2W9', '$2y$10$1MueN0FkWwglBP501fXdjePBWxbZM3HHvWnZo/SN5gSJRnEPPtIme', 'a689d96dcbb966b77c064ede65139e20', 1, 1, '2025-07-27 19:20:49'),
(9, 'asus', 'asus', 'amroli', 'asus@mail.com', '4567890123', '25VWAHS3169B2A2', '$2y$10$4Eo.kgQLK.9cSa10p.jure8uo2p7YUvGECdV4qp39XenNuhmQSoZq', '9d429b52400d5cbe8ca619c7e3eef16f', 1, 1, '2025-07-27 19:21:46'),
(10, 'dell', 'dell', 'amroli', 'dell@mail.com', '9726331300', '24VWSHS3169C3Z6', '$2y$10$4CNW/eKqysAbjJmOTTGQ1ONoydvqI0KSyhWPLbW7pIGvPP1XmhEWe', '0629c31a938e2b0104f377721e5d5e83', 1, 1, '2025-07-27 19:33:41'),
(11, 'Chavda Mehul', 'chavda', 'amroli', 'chavdamehul105@gmail.com', '9726331300', '25VWAHS3169B2W9', '$2y$10$cbkpwHIJTDXn0hwOQzaS.uOJZJI4o7ZcmAaMEoCPu64jK4qMSpjhy', '', 1, 1, '2025-07-30 17:22:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_color`
--

CREATE TABLE `tbl_color` (
  `color_id` int(11) NOT NULL,
  `color_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_color`
--

INSERT INTO `tbl_color` (`color_id`, `color_name`) VALUES
(1, 'Red'),
(2, 'Black'),
(3, 'Blue'),
(4, 'Yellow'),
(5, 'Green'),
(6, 'White'),
(7, 'Orange'),
(8, 'Brown'),
(9, 'Tan'),
(10, 'Pink'),
(11, 'Mixed'),
(12, 'Lightblue'),
(13, 'Violet'),
(14, 'Light Purple'),
(15, 'Salmon'),
(16, 'Gold'),
(17, 'Gray'),
(18, 'Ash'),
(19, 'Maroon'),
(20, 'Silver'),
(21, 'Dark Clay'),
(22, 'Cognac'),
(23, 'Coffee'),
(24, 'Charcoal'),
(25, 'Navy'),
(26, 'Fuchsia'),
(27, 'Olive'),
(28, 'Burgundy'),
(29, 'Midnight Blue');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact_messages`
--

CREATE TABLE `tbl_contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_contact_messages`
--

INSERT INTO `tbl_contact_messages` (`id`, `name`, `email`, `phone`, `message`, `is_read`, `created_at`) VALUES
(1, 'Chavda Mehul', 'chavdamehul105@gmail.com', '9726331300', 'hello nice website', 1, '2025-07-19 16:47:35'),
(9, 'Chavda Mehul', 'chavdamehul105@gmail.com', '9726331300', 'nice website', 1, '2025-07-30 17:25:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_country`
--

CREATE TABLE `tbl_country` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_country`
--

INSERT INTO `tbl_country` (`country_id`, `country_name`) VALUES
(1, 'Afghanistan'),
(2, 'Albania'),
(3, 'Algeria'),
(4, 'American Samoa'),
(5, 'Andorra'),
(6, 'Angola'),
(7, 'Anguilla'),
(8, 'Antarctica'),
(9, 'Antigua and Barbuda'),
(10, 'Argentina'),
(11, 'Armenia'),
(12, 'Aruba'),
(13, 'Australia'),
(14, 'Austria'),
(15, 'Azerbaijan'),
(16, 'Bahamas'),
(17, 'Bahrain'),
(18, 'Bangladesh'),
(19, 'Barbados'),
(20, 'Belarus'),
(21, 'Belgium'),
(22, 'Belize'),
(23, 'Benin'),
(24, 'Bermuda'),
(25, 'Bhutan'),
(26, 'Bolivia'),
(27, 'Bosnia and Herzegovina'),
(28, 'Botswana'),
(29, 'Bouvet Island'),
(30, 'Brazil'),
(31, 'British Indian Ocean Territory'),
(32, 'Brunei Darussalam'),
(33, 'Bulgaria'),
(34, 'Burkina Faso'),
(35, 'Burundi'),
(36, 'Cambodia'),
(37, 'Cameroon'),
(38, 'Canada'),
(39, 'Cape Verde'),
(40, 'Cayman Islands'),
(41, 'Central African Republic'),
(42, 'Chad'),
(43, 'Chile'),
(44, 'China'),
(45, 'Christmas Island'),
(46, 'Cocos (Keeling) Islands'),
(47, 'Colombia'),
(48, 'Comoros'),
(49, 'Congo'),
(50, 'Cook Islands'),
(51, 'Costa Rica'),
(52, 'Croatia (Hrvatska)'),
(53, 'Cuba'),
(54, 'Cyprus'),
(55, 'Czech Republic'),
(56, 'Denmark'),
(57, 'Djibouti'),
(58, 'Dominica'),
(59, 'Dominican Republic'),
(60, 'East Timor'),
(61, 'Ecuador'),
(62, 'Egypt'),
(63, 'El Salvador'),
(64, 'Equatorial Guinea'),
(65, 'Eritrea'),
(66, 'Estonia'),
(67, 'Ethiopia'),
(68, 'Falkland Islands (Malvinas)'),
(69, 'Faroe Islands'),
(70, 'Fiji'),
(71, 'Finland'),
(72, 'France'),
(73, 'France, Metropolitan'),
(74, 'French Guiana'),
(75, 'French Polynesia'),
(76, 'French Southern Territories'),
(77, 'Gabon'),
(78, 'Gambia'),
(79, 'Georgia'),
(80, 'Germany'),
(81, 'Ghana'),
(82, 'Gibraltar'),
(83, 'Guernsey'),
(84, 'Greece'),
(85, 'Greenland'),
(86, 'Grenada'),
(87, 'Guadeloupe'),
(88, 'Guam'),
(89, 'Guatemala'),
(90, 'Guinea'),
(91, 'Guinea-Bissau'),
(92, 'Guyana'),
(93, 'Haiti'),
(94, 'Heard and Mc Donald Islands'),
(95, 'Honduras'),
(96, 'Hong Kong'),
(97, 'Hungary'),
(98, 'Iceland'),
(99, 'India'),
(100, 'Isle of Man'),
(101, 'Indonesia'),
(102, 'Iran (Islamic Republic of)'),
(103, 'Iraq'),
(104, 'Ireland'),
(105, 'Israel'),
(106, 'Italy'),
(107, 'Ivory Coast'),
(108, 'Jersey'),
(109, 'Jamaica'),
(110, 'Japan'),
(111, 'Jordan'),
(112, 'Kazakhstan'),
(113, 'Kenya'),
(114, 'Kiribati'),
(115, 'Korea, Democratic People\'s Republic of'),
(116, 'Korea, Republic of'),
(117, 'Kosovo'),
(118, 'Kuwait'),
(119, 'Kyrgyzstan'),
(120, 'Lao People\'s Democratic Republic'),
(121, 'Latvia'),
(122, 'Lebanon'),
(123, 'Lesotho'),
(124, 'Liberia'),
(125, 'Libyan Arab Jamahiriya'),
(126, 'Liechtenstein'),
(127, 'Lithuania'),
(128, 'Luxembourg'),
(129, 'Macau'),
(130, 'Macedonia'),
(131, 'Madagascar'),
(132, 'Malawi'),
(133, 'Malaysia'),
(134, 'Maldives'),
(135, 'Mali'),
(136, 'Malta'),
(137, 'Marshall Islands'),
(138, 'Martinique'),
(139, 'Mauritania'),
(140, 'Mauritius'),
(141, 'Mayotte'),
(142, 'Mexico'),
(143, 'Micronesia, Federated States of'),
(144, 'Moldova, Republic of'),
(145, 'Monaco'),
(146, 'Mongolia'),
(147, 'Montenegro'),
(148, 'Montserrat'),
(149, 'Morocco'),
(150, 'Mozambique'),
(151, 'Myanmar'),
(152, 'Namibia'),
(153, 'Nauru'),
(154, 'Nepal'),
(155, 'Netherlands'),
(156, 'Netherlands Antilles'),
(157, 'New Caledonia'),
(158, 'New Zealand'),
(159, 'Nicaragua'),
(160, 'Niger'),
(161, 'Nigeria'),
(162, 'Niue'),
(163, 'Norfolk Island'),
(164, 'Northern Mariana Islands'),
(165, 'Norway'),
(166, 'Oman'),
(167, 'Pakistan'),
(168, 'Palau'),
(169, 'Palestine'),
(170, 'Panama'),
(171, 'Papua New Guinea'),
(172, 'Paraguay'),
(173, 'Peru'),
(174, 'Philippines'),
(175, 'Pitcairn'),
(176, 'Poland'),
(177, 'Portugal'),
(178, 'Puerto Rico'),
(179, 'Qatar'),
(180, 'Reunion'),
(181, 'Romania'),
(182, 'Russian Federation'),
(183, 'Rwanda'),
(184, 'Saint Kitts and Nevis'),
(185, 'Saint Lucia'),
(186, 'Saint Vincent and the Grenadines'),
(187, 'Samoa'),
(188, 'San Marino'),
(189, 'Sao Tome and Principe'),
(190, 'Saudi Arabia'),
(191, 'Senegal'),
(192, 'Serbia'),
(193, 'Seychelles'),
(194, 'Sierra Leone'),
(195, 'Singapore'),
(196, 'Slovakia'),
(197, 'Slovenia'),
(198, 'Solomon Islands'),
(199, 'Somalia'),
(200, 'South Africa'),
(201, 'South Georgia South Sandwich Islands'),
(202, 'Spain'),
(203, 'Sri Lanka'),
(204, 'St. Helena'),
(205, 'St. Pierre and Miquelon'),
(206, 'Sudan'),
(207, 'Suriname'),
(208, 'Svalbard and Jan Mayen Islands'),
(209, 'Swaziland'),
(210, 'Sweden'),
(211, 'Switzerland'),
(212, 'Syrian Arab Republic'),
(213, 'Taiwan'),
(214, 'Tajikistan'),
(215, 'Tanzania, United Republic of'),
(216, 'Thailand'),
(217, 'Togo'),
(218, 'Tokelau'),
(219, 'Tonga'),
(220, 'Trinidad and Tobago'),
(221, 'Tunisia'),
(222, 'Turkey'),
(223, 'Turkmenistan'),
(224, 'Turks and Caicos Islands'),
(225, 'Tuvalu'),
(226, 'Uganda'),
(227, 'Ukraine'),
(228, 'United Arab Emirates'),
(229, 'United Kingdom'),
(230, 'United States'),
(231, 'United States minor outlying islands'),
(232, 'Uruguay'),
(233, 'Uzbekistan'),
(234, 'Vanuatu'),
(235, 'Vatican City State'),
(236, 'Venezuela'),
(237, 'Vietnam'),
(238, 'Virgin Islands (British)'),
(239, 'Virgin Islands (U.S.)'),
(240, 'Wallis and Futuna Islands'),
(241, 'Western Sahara'),
(242, 'Yemen'),
(243, 'Zaire'),
(244, 'Zambia'),
(245, 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `cust_id` int(11) NOT NULL,
  `cust_name` varchar(100) NOT NULL,
  `cust_cname` varchar(100) NOT NULL,
  `cust_email` varchar(100) NOT NULL,
  `cust_phone` varchar(50) NOT NULL,
  `cust_country` int(11) NOT NULL,
  `cust_address` text NOT NULL,
  `cust_city` varchar(100) NOT NULL,
  `cust_state` varchar(100) NOT NULL,
  `cust_zip` varchar(30) NOT NULL,
  `cust_b_name` varchar(100) NOT NULL,
  `cust_b_cname` varchar(100) NOT NULL,
  `cust_b_phone` varchar(50) NOT NULL,
  `cust_b_country` int(11) NOT NULL,
  `cust_b_address` text NOT NULL,
  `cust_b_city` varchar(100) NOT NULL,
  `cust_b_state` varchar(100) NOT NULL,
  `cust_b_zip` varchar(30) NOT NULL,
  `cust_s_name` varchar(100) NOT NULL,
  `cust_s_cname` varchar(100) NOT NULL,
  `cust_s_phone` varchar(50) NOT NULL,
  `cust_s_country` int(11) NOT NULL,
  `cust_s_address` text NOT NULL,
  `cust_s_city` varchar(100) NOT NULL,
  `cust_s_state` varchar(100) NOT NULL,
  `cust_s_zip` varchar(30) NOT NULL,
  `cust_password` varchar(100) NOT NULL,
  `cust_token` varchar(255) NOT NULL,
  `cust_datetime` varchar(100) NOT NULL,
  `cust_timestamp` varchar(100) NOT NULL,
  `cust_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`cust_id`, `cust_name`, `cust_cname`, `cust_email`, `cust_phone`, `cust_country`, `cust_address`, `cust_city`, `cust_state`, `cust_zip`, `cust_b_name`, `cust_b_cname`, `cust_b_phone`, `cust_b_country`, `cust_b_address`, `cust_b_city`, `cust_b_state`, `cust_b_zip`, `cust_s_name`, `cust_s_cname`, `cust_s_phone`, `cust_s_country`, `cust_s_address`, `cust_s_city`, `cust_s_state`, `cust_s_zip`, `cust_password`, `cust_token`, `cust_datetime`, `cust_timestamp`, `cust_status`) VALUES
(12, 'nick', '', 'nick@gmail.com', '1212121212', 99, 'home', 'surat', 'Gujarat', '394107', '', '', '', 0, '', '', '', '', '', '', '', 0, '', '', '', '', '202cb962ac59075b964b07152d234b70', '7e9e884c1f2d29ec3fe57d163684ddc6', '2025-07-09 03:59:28', '1752058768', 1),
(17, 'meet', '', 'mehulchavda1275@gmail.com', '1231231231', 99, 'barora', 'vadodra', 'Gujarat', '394107', '', '', '', 0, '', '', '', '', '', '', '', 0, '', '', '', '', '81dc9bdb52d04dc20036dbd8313ed055', '', '2025-07-10 11:33:04', '1752215584', 1),
(19, 'raj', 'nike', 'raj@gmail.com', '5454545454', 99, 'amroli', 'surat', 'Gujarat', '394107', '', '', '', 0, '', '', '', '', '', '', '', 0, '', '', '', '', '$2y$10$FbZ1hV5c9ORJnc.nN.x0zeB3O.tn/59URoKG5NRdPKmuPoz3T2nHm', '063c15c7f01d1b03e36a339f2ab51565', '2025-07-19 07:10:57', '1752934257', 1),
(24, 'Chavda Mehul', 'Chavda Mehul', 'chavdamehul105@gmail.com', '9726331300', 99, 'amroli', 'surat', 'Gujarat', '394107', 'Chavda Mehul', 'nike', '9726331300', 99, 'amroli', 'surat', 'Gujarat', '394107', 'Chavda Mehul', 'nike', '9726331300', 99, 'amroli', 'surat', 'Gujarat', '394107', '$2y$10$23GWsaPOuRw4bNvNfQtrp.X9S0ip.XNXJ6nvmSl7ZAvmOoctY6Zx.', '', '2025-07-30 04:49:39', '', 1),
(26, 'nand', 'nand', 'nandpatel712005@gmail.com', '5454545454', 99, 'amroli', 'surat', 'Gujarat', '394107', 'nand', 'nike', '1234567890', 99, 'amroli', 'surat', 'Gujarat', '394107', 'nand', 'nike', '1234567890', 99, 'amroli', 'surat', 'Gujarat', '394107', '$2y$10$6q756KNdc.LOS9AcHzrQzuQ6IBEdKXg3wYpu4C4BeO7Xua5OlBmnC', '546eb6b9c59e582b1c93e0189a39fe474c3053cf94e03cca66f1864755fa0c29', '2025-08-04 06:02:07', '1754312527', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_message`
--

CREATE TABLE `tbl_customer_message` (
  `customer_message_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `order_detail` text NOT NULL,
  `cust_id` int(11) NOT NULL,
  `type` varchar(10) DEFAULT 'email'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_customer_message`
--

INSERT INTO `tbl_customer_message` (`customer_message_id`, `subject`, `message`, `order_detail`, `cust_id`, `type`) VALUES
(9, 'deleverd', 'onsdadiuasn', '\nCustomer Name: Will Williams<br>\nCustomer Email: williams@mail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2022-03-20 11:28:22<br>\nPayment Details: <br>\nTransaction Details: <br>Transaction Id: CA01003177945009\r\nTransaction Date: 3/20/2022 \r\nBank: WestView Bank, CA Branch \r\nSender A/C: NQ1011050160WV<br>\nPaid Amount: 149<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1647800902<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: WD 5TB Elements Portable External Hard Drive HDD<br>\nSize: 5T<br>\nColor: Black<br>\nQuantity: 1<br>\nUnit Price: 149<br>\n            ', 10, 'email'),
(10, 'deleverd', 'delervd in soon ', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-05 05:35:22<br>\nPayment Details: <br>\nTransaction Details: <br>Bank Name: WestView Bank\r\nAccount Number: CA100270589600\r\nBranch Name: CA Branch\r\nCountry: USA<br>\nPaid Amount: 279<br>\nPayment Status: Pending<br>\nShipping Status: Pending<br>\nPayment Id: 1751718922<br>\n            ', 11, 'email'),
(11, 'deleverd', 'delervd in soon ', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-05 05:35:22<br>\nPayment Details: <br>\nTransaction Details: <br>Bank Name: WestView Bank\r\nAccount Number: CA100270589600\r\nBranch Name: CA Branch\r\nCountry: USA<br>\nPaid Amount: 279<br>\nPayment Status: Pending<br>\nShipping Status: Pending<br>\nPayment Id: 1751718922<br>\n            ', 11, 'email'),
(12, 'deleverd', 'axa', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-06 02:28:06<br>\nPayment Details: <br>\nTransaction Details: <br>12eiwhdnq8931w<br>\nPaid Amount: 191<br>\nPayment Status: Completed<br>\nShipping Status: Pending<br>\nPayment Id: 1751794086<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: Travelpro Laptop Carry-on Travel Tote Bag<br>\nSize: One Size for All<br>\nColor: Black<br>\nQuantity: 1<br>\nUnit Price: 91<br>\n            ', 11, 'email'),
(13, 'deleverd', '3e3e3e3e3e3', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: PayPal<br>\nPayment Date: 2025-07-10 03:48:21<br>\nPayment Details: <br>\nTransaction Id: <br>\n        		<br>\nPaid Amount: 279<br>\nPayment Status: Pending<br>\nShipping Status: Pending<br>\nPayment Id: 1752144501<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: Amazfit GTS 3 Smart Watch for Android iPhone<br>\nSize: Free Size<br>\nColor: Black<br>\nQuantity: 1<br>\nUnit Price: 179<br>\n            ', 11, 'email'),
(14, 'deleverd', 'see the mail bitch\r\n', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: PayPal<br>\nPayment Date: 2025-07-10 03:48:21<br>\nPayment Details: <br>\nTransaction Id: <br>\n        		<br>\nPaid Amount: 279<br>\nPayment Status: Pending<br>\nShipping Status: Pending<br>\nPayment Id: 1752144501<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: Amazfit GTS 3 Smart Watch for Android iPhone<br>\nSize: Free Size<br>\nColor: Black<br>\nQuantity: 1<br>\nUnit Price: 179<br>\n            ', 11, 'email'),
(15, 'succsecfully deleverd', 'we delevrd your prodect to you \r\nthank you\r\n', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: PayPal<br>\nPayment Date: 2025-07-10 03:48:21<br>\nPayment Details: <br>\nTransaction Id: <br>\n        		<br>\nPaid Amount: 279<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1752144501<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: Amazfit GTS 3 Smart Watch for Android iPhone<br>\nSize: Free Size<br>\nColor: Black<br>\nQuantity: 1<br>\nUnit Price: 179<br>\n            ', 11, 'email'),
(16, 'deleverde23e2e', '3e23e32e32e', '\nCustomer Name: Will Williams<br>\nCustomer Email: williams@mail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2022-03-20 11:28:22<br>\nPayment Details: <br>\nTransaction Details: <br>Transaction Id: CA01003177945009\r\nTransaction Date: 3/20/2022 \r\nBank: WestView Bank, CA Branch \r\nSender A/C: NQ1011050160WV<br>\nPaid Amount: 149<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1647800902<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: WD 5TB Elements Portable External Hard Drive HDD<br>\nSize: 5T<br>\nColor: Black<br>\nQuantity: 1<br>\nUnit Price: 149<br>\n            ', 10, 'email'),
(17, 'laptop ', 'we will sent to you soon\r\n', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-12 05:02:08<br>\nPayment Details: <br>\nTransaction Details: <br>qsqsq<br>\nPaid Amount: 313<br>\nPayment Status: Pending<br>\nShipping Status: Pending<br>\nPayment Id: 1752321728<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: qwdqd<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 213<br>\n            ', 11, 'email'),
(18, 'laptop ', 'acccds', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-12 05:02:08<br>\nPayment Details: <br>\nTransaction Details: <br>qsqsq<br>\nPaid Amount: 313<br>\nPayment Status: Completed<br>\nShipping Status: Pending<br>\nPayment Id: 1752321728<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: qwdqd<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 213<br>\n            ', 11, 'email'),
(19, 'deleverd', 'see the mail bhosdina', '\nCustomer Name: nand<br>\nCustomer Email: nandpatel712005@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-17 22:45:58<br>\nPayment Details: <br>\nTransaction Details: <br>ank Name: WestView Bank\r\nAccount Number: CA100270589600\r\nBranch Name: CA Branch\r\nCountry: USA<br>\nPaid Amount: 279<br>\nPayment Status: Pending<br>\nShipping Status: Pending<br>\nPayment Id: 1752817558<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: Amazfit GTS 3 Smart Watch for Android iPhone<br>\nSize: Free Size<br>\nColor: Black<br>\nQuantity: 1<br>\nUnit Price: 179<br>\n            ', 18, 'email'),
(20, 'deleverd', 'see the mail bhosdina', '\nCustomer Name: nand<br>\nCustomer Email: nandpatel712005@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-17 22:45:58<br>\nPayment Details: <br>\nTransaction Details: <br>ank Name: WestView Bank\r\nAccount Number: CA100270589600\r\nBranch Name: CA Branch\r\nCountry: USA<br>\nPaid Amount: 279<br>\nPayment Status: Pending<br>\nShipping Status: Pending<br>\nPayment Id: 1752817558<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: Amazfit GTS 3 Smart Watch for Android iPhone<br>\nSize: Free Size<br>\nColor: Black<br>\nQuantity: 1<br>\nUnit Price: 179<br>\n            ', 18, 'email'),
(21, 'deleverd', 'rfdef', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-12 05:02:08<br>\nPayment Details: <br>\nTransaction Details: <br>qsqsq<br>\nPaid Amount: 313<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1752321728<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: qwdqd<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 213<br>\n            ', 11, 'email'),
(22, 'deleverd', 'rfdef', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-12 05:02:08<br>\nPayment Details: <br>\nTransaction Details: <br>qsqsq<br>\nPaid Amount: 313<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1752321728<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: qwdqd<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 213<br>\n            ', 11, 'email'),
(23, 'deleverd', 'sddssd', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-12 05:02:08<br>\nPayment Details: <br>\nTransaction Details: <br>qsqsq<br>\nPaid Amount: 313<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1752321728<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: qwdqd<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 213<br>\n            ', 11, 'email'),
(24, 'deleverd', 'assxsa', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-12 05:02:08<br>\nPayment Details: <br>\nTransaction Details: <br>qsqsq<br>\nPaid Amount: 313<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1752321728<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: qwdqd<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 213<br>\n            ', 11, 'email'),
(25, 'email ni je maa choydi ', 'bc aa mail ma kai nay karta \r\npassword change thay gyo \r\nemail jata band thay gya hta\r\nmand mand kayru\r\n', '\nCustomer Name: nand<br>\nCustomer Email: nandpatel712005@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-17 22:45:58<br>\nPayment Details: <br>\nTransaction Details: <br>ank Name: WestView Bank\r\nAccount Number: CA100270589600\r\nBranch Name: CA Branch\r\nCountry: USA<br>\nPaid Amount: 279<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1752817558<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: Amazfit GTS 3 Smart Watch for Android iPhone<br>\nSize: Free Size<br>\nColor: Black<br>\nQuantity: 1<br>\nUnit Price: 179<br>\n            ', 18, 'email'),
(26, 'laptop ', 'fccs', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-20 05:26:02<br>\nPayment Details: <br>\nTransaction Details: <br>sbi<br>\nPaid Amount: 150<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1753014362<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: Gold Plated Leopard Print Crystal Big Round Hoop Earrings<br>\nSize: <br>\nColor: <br>\nQuantity: 2<br>\nUnit Price: 25<br>\n            ', 11, 'email'),
(27, 'deleverd', 'sdfdsfs', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-23 04:26:01<br>\nPayment Details: <br>\nTransaction Details: <br>Bank Name: WestView Bank\r\nAccount Number: CA100270589600\r\nBranch Name: CA Branch\r\nCountry: USA<br>\nPaid Amount: 60100<br>\nPayment Status: Pending<br>\nShipping Status: Pending<br>\nPayment Id: 1753269961<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: pc<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 60000<br>\n            ', 11, 'email'),
(28, 'deleverd', 'see the products\r\n', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: PayPal<br>\nPayment Date: 2025-07-23 04:46:10<br>\nPayment Details: <br>\nTransaction Id: <br>\n        		<br>\nPaid Amount: 45100<br>\nPayment Status: Pending<br>\nShipping Status: Pending<br>\nPayment Id: 1753271170<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: laptop<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 45000<br>\n            ', 11, 'email'),
(29, 'deleverd', 'see the products\r\n', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: PayPal<br>\nPayment Date: 2025-07-23 04:46:10<br>\nPayment Details: <br>\nTransaction Id: <br>\n        		<br>\nPaid Amount: 45100<br>\nPayment Status: Pending<br>\nShipping Status: Pending<br>\nPayment Id: 1753271170<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: laptop<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 45000<br>\n            ', 11, 'sms'),
(30, 'Your Payment is Completed', 'Dear Chavda Mehul, Your payment (Payment ID: 1753271170) has been marked as Completed by admin. Thank you for shopping with us! - E-martz', 'Payment marked complete', 11, 'sms'),
(31, 'deleverd', 'dwdwwdwd', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: PayPal<br>\nPayment Date: 2025-07-23 04:46:10<br>\nPayment Details: <br>\nTransaction Id: <br>\n        		<br>\nPaid Amount: 45100<br>\nPayment Status: Completed<br>\nShipping Status: Pending<br>\nPayment Id: 1753271170<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: laptop<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 45000<br>\n            ', 11, 'email'),
(32, 'deleverd', 'dwdwwdwd', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: PayPal<br>\nPayment Date: 2025-07-23 04:46:10<br>\nPayment Details: <br>\nTransaction Id: <br>\n        		<br>\nPaid Amount: 45100<br>\nPayment Status: Completed<br>\nShipping Status: Pending<br>\nPayment Id: 1753271170<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: laptop<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 45000<br>\n            ', 11, 'sms'),
(33, 'deleverdwwq', 'wqwqwqw', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-23 05:39:22<br>\nPayment Details: <br>\nTransaction Details: <br>SBI<br>\nPaid Amount: 60100<br>\nPayment Status: Pending<br>\nShipping Status: Pending<br>\nPayment Id: 1753274362<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: pc<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 60000<br>\n            ', 11, 'email'),
(34, 'deleverdwwq', 'wqwqwqw', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-23 05:39:22<br>\nPayment Details: <br>\nTransaction Details: <br>SBI<br>\nPaid Amount: 60100<br>\nPayment Status: Pending<br>\nShipping Status: Pending<br>\nPayment Id: 1753274362<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: pc<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 60000<br>\n            ', 11, 'sms'),
(35, 'Your Payment is Completed', 'Dear Chavda Mehul, Your payment (Payment ID: 1753274362) has been marked as Completed by admin. Thank you for shopping with us! - E-martz', 'Payment marked complete', 11, 'sms'),
(36, 'laptop ', 'sqssq', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-23 05:50:24<br>\nPayment Details: <br>\nTransaction Details: <br>sas<br>\nPaid Amount: 60100<br>\nPayment Status: Pending<br>\nShipping Status: Pending<br>\nPayment Id: 1753275024<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: pc<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 60000<br>\n            ', 11, 'email'),
(37, 'laptop ', 'sqssq', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-23 05:50:24<br>\nPayment Details: <br>\nTransaction Details: <br>sas<br>\nPaid Amount: 60100<br>\nPayment Status: Pending<br>\nShipping Status: Pending<br>\nPayment Id: 1753275024<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: pc<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 60000<br>\n            ', 11, 'sms'),
(38, 'Your Payment is Completed', 'Dear Chavda Mehul, Your payment (Payment ID: 1753275024) has been marked as Completed by admin. Thank you for shopping with us! - E-martz', 'Payment marked complete', 11, 'sms'),
(39, 'deleverd', 'jhv', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-23 05:50:24<br>\nPayment Details: <br>\nTransaction Details: <br>sas<br>\nPaid Amount: 60100<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1753275024<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: pc<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 60000<br>\n            ', 11, 'email'),
(40, 'deleverd', 'jhv', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-23 05:50:24<br>\nPayment Details: <br>\nTransaction Details: <br>sas<br>\nPaid Amount: 60100<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1753275024<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: pc<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 60000<br>\n            ', 11, 'sms'),
(41, 'deleverd', 'jhv', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-23 05:50:24<br>\nPayment Details: <br>\nTransaction Details: <br>sas<br>\nPaid Amount: 60100<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1753275024<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: pc<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 60000<br>\n            ', 11, 'email'),
(42, 'deleverd', 'jhv', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-23 05:50:24<br>\nPayment Details: <br>\nTransaction Details: <br>sas<br>\nPaid Amount: 60100<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1753275024<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: pc<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 60000<br>\n            ', 11, 'sms'),
(43, 'deleverd', 'soon', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-23 05:50:24<br>\nPayment Details: <br>\nTransaction Details: <br>sas<br>\nPaid Amount: 60100<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1753275024<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: pc<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 60000<br>\n            ', 11, 'email'),
(44, 'deleverd', 'soon', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-23 05:50:24<br>\nPayment Details: <br>\nTransaction Details: <br>sas<br>\nPaid Amount: 60100<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1753275024<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: pc<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 60000<br>\n            ', 11, 'sms'),
(45, 'laptop qwdqwd', 'qwdqwdwdwqd', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-23 05:50:24<br>\nPayment Details: <br>\nTransaction Details: <br>sas<br>\nPaid Amount: 60100<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1753275024<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: pc<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 60000<br>\n            ', 11, 'email'),
(46, 'laptop qwdqwd', 'qwdqwdwdwqd', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-23 05:50:24<br>\nPayment Details: <br>\nTransaction Details: <br>sas<br>\nPaid Amount: 60100<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1753275024<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: pc<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 60000<br>\n            ', 11, 'sms'),
(47, 'laptop ', 'hello', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-23 05:50:24<br>\nPayment Details: <br>\nTransaction Details: <br>sas<br>\nPaid Amount: 60100<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1753275024<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: pc<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 60000<br>\n            ', 11, 'email'),
(48, 'laptop ', 'hello', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-23 05:50:24<br>\nPayment Details: <br>\nTransaction Details: <br>sas<br>\nPaid Amount: 60100<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1753275024<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: pc<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 60000<br>\n            ', 11, 'sms'),
(49, 'laptop ', 'hello', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-23 05:50:24<br>\nPayment Details: <br>\nTransaction Details: <br>sas<br>\nPaid Amount: 60100<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1753275024<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: pc<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 60000<br>\n            ', 11, 'email'),
(50, 'laptop ', 'hello', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-23 05:50:24<br>\nPayment Details: <br>\nTransaction Details: <br>sas<br>\nPaid Amount: 60100<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1753275024<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: pc<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 60000<br>\n            ', 11, 'sms'),
(51, 'Your Payment is Completed', 'Dear Chavda Mehul, Your payment (Payment ID: 1753334316) has been marked as Completed by admin. Thank you for shopping with us! - E-martz', 'Payment marked complete', 11, 'sms'),
(52, 'deleverd', 'seen', 'Customer Name: Chavda Mehul<br>Customer Email: chavdamehul105@gmail.com<br>Payment Method: Bank Deposit<br>Payment Date: 2025-07-24 06:10:48<br>Paid Amount: 500<br>Payment Status: Pending<br>Shipping Status: Pending<br>Payment Id: 1753362648<br><br><b><u>Product Item 1</u></b><br>Product Name: laptop<br>Size: <br>Color: <br>Quantity: 1<br>Unit Price: 400<br>', 11, 'email'),
(53, 'deleverd', 'seen', 'Customer Name: Chavda Mehul<br>Customer Email: chavdamehul105@gmail.com<br>Payment Method: Bank Deposit<br>Payment Date: 2025-07-24 06:10:48<br>Paid Amount: 500<br>Payment Status: Pending<br>Shipping Status: Pending<br>Payment Id: 1753362648<br><br><b><u>Product Item 1</u></b><br>Product Name: laptop<br>Size: <br>Color: <br>Quantity: 1<br>Unit Price: 400<br>', 11, 'sms'),
(54, 'laptop ', 'ddd\r\n', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-26 05:38:39<br>\nPayment Details: <br>\nTransaction Details: <br>123<br>\nPaid Amount: 2200<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1753533519<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: headphone<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 2100<br>\n            ', 11, 'email'),
(55, 'laptop ', 'ddd\r\n', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-26 05:38:39<br>\nPayment Details: <br>\nTransaction Details: <br>123<br>\nPaid Amount: 2200<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1753533519<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: headphone<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 2100<br>\n            ', 11, 'sms'),
(56, 'deleverd3ee', '3e3e3', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-26 05:38:39<br>\nPayment Details: <br>\nTransaction Details: <br>123<br>\nPaid Amount: 2200<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1753533519<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: headphone<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 2100<br>\n            ', 11, 'email'),
(57, 'deleverd3ee', '3e3e3', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-26 05:38:39<br>\nPayment Details: <br>\nTransaction Details: <br>123<br>\nPaid Amount: 2200<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1753533519<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: headphone<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 2100<br>\n            ', 11, 'sms'),
(58, 'deleverd', 'dd', 'Customer Name: Chavda Mehul<br>Customer Email: chavdamehul105@gmail.com<br>Payment Method: Bank Deposit<br>Payment Date: 2025-07-30 05:18:53<br>Paid Amount: 4499<br>Payment Status: Completed<br>Shipping Status: Completed<br>Payment Id: 1753877933<br><br><b><u>Product Item 1</u></b><br>Product Name: Ray-Ban Junior Unisex Round Sunglasses - 0RJ9547S<br>Size: <br>Color: <br>Quantity: 1<br>Unit Price: 4399<br>', 24, 'email'),
(59, 'deleverd', 'dd', 'Customer Name: Chavda Mehul<br>Customer Email: chavdamehul105@gmail.com<br>Payment Method: Bank Deposit<br>Payment Date: 2025-07-30 05:18:53<br>Paid Amount: 4499<br>Payment Status: Completed<br>Shipping Status: Completed<br>Payment Id: 1753877933<br><br><b><u>Product Item 1</u></b><br>Product Name: Ray-Ban Junior Unisex Round Sunglasses - 0RJ9547S<br>Size: <br>Color: <br>Quantity: 1<br>Unit Price: 4399<br>', 24, 'sms'),
(60, 'laptop asa', 'sas', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-26 05:38:39<br>\nPayment Details: <br>\nTransaction Details: <br>123<br>\nPaid Amount: 2200<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1753533519<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: headphone<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 2100<br>\n            ', 11, 'email'),
(61, 'deleverdas', 'asa', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-26 05:38:39<br>\nPayment Details: <br>\nTransaction Details: <br>123<br>\nPaid Amount: 2200<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1753533519<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: headphone<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 2100<br>\n            ', 11, 'email'),
(62, 'deleverd', 'sf', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-26 05:38:39<br>\nPayment Details: <br>\nTransaction Details: <br>123<br>\nPaid Amount: 2200<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1753533519<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: headphone<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 2100<br>\n            ', 11, 'email'),
(63, 'Your Payment is Completed', 'Dear Chavda Mehul, Your payment (Payment ID: 1753878220) has been marked as Completed by admin. Thank you for shopping with us! - E-martz', 'Payment marked complete', 24, 'sms'),
(64, 'deleverd', 'aa', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-30 05:23:40<br>\nPayment Details: <br>\nTransaction Details: <br>sbi<br>\nPaid Amount: 4499<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1753878220<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: Ray-Ban Junior Unisex Round Sunglasses - 0RJ9547S<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 4399<br>\n            ', 24, 'email'),
(65, 'deleverd', 'aa', '\nCustomer Name: Chavda Mehul<br>\nCustomer Email: chavdamehul105@gmail.com<br>\nPayment Method: Bank Deposit<br>\nPayment Date: 2025-07-30 05:23:40<br>\nPayment Details: <br>\nTransaction Details: <br>sbi<br>\nPaid Amount: 4499<br>\nPayment Status: Completed<br>\nShipping Status: Completed<br>\nPayment Id: 1753878220<br>\n            \n<br><b><u>Product Item 1</u></b><br>\nProduct Name: Ray-Ban Junior Unisex Round Sunglasses - 0RJ9547S<br>\nSize: <br>\nColor: <br>\nQuantity: 1<br>\nUnit Price: 4399<br>\n            ', 24, 'sms'),
(66, 'laptop ', 'sedc', 'Customer Name: Chavda Mehul<br>Customer Email: chavdamehul105@gmail.com<br>Payment Method: Bank Deposit<br>Payment Date: 2025-07-30 05:23:40<br>Paid Amount: 4499<br>Payment Status: Completed<br>Shipping Status: Completed<br>Payment Id: 1753878220<br><br><b><u>Product Item 1</u></b><br>Product Name: Ray-Ban Junior Unisex Round Sunglasses - 0RJ9547S<br>Size: <br>Color: <br>Quantity: 1<br>Unit Price: 4399<br>', 24, 'email'),
(67, 'laptop ', 'sedc', 'Customer Name: Chavda Mehul<br>Customer Email: chavdamehul105@gmail.com<br>Payment Method: Bank Deposit<br>Payment Date: 2025-07-30 05:23:40<br>Paid Amount: 4499<br>Payment Status: Completed<br>Shipping Status: Completed<br>Payment Id: 1753878220<br><br><b><u>Product Item 1</u></b><br>Product Name: Ray-Ban Junior Unisex Round Sunglasses - 0RJ9547S<br>Size: <br>Color: <br>Quantity: 1<br>Unit Price: 4399<br>', 24, 'sms');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_end_category`
--

CREATE TABLE `tbl_end_category` (
  `ecat_id` int(11) NOT NULL,
  `ecat_name` varchar(255) NOT NULL,
  `mcat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_end_category`
--

INSERT INTO `tbl_end_category` (`ecat_id`, `ecat_name`, `mcat_id`) VALUES
(1, 'Headwear ', 1),
(2, 'Sunglasses', 1),
(3, 'Watches', 1),
(4, 'Sandals', 2),
(5, 'Boots', 2),
(6, 'Tops', 3),
(7, 'T-Shirt', 3),
(8, 'Watches', 4),
(9, 'Sunglasses', 4),
(11, 'Sports Shoes', 2),
(12, 'Sandals', 6),
(13, 'Flat Shoes', 6),
(14, 'Hoodies', 7),
(15, 'Coats & Jackets', 7),
(16, 'Pants', 8),
(17, 'Jeans', 8),
(18, 'Joggers', 8),
(19, 'Shorts', 8),
(20, 'T-shirts', 9),
(21, 'Casual Shirts', 9),
(22, 'Formal Shirts', 9),
(23, 'Polo Shirts', 9),
(24, 'Vests', 9),
(25, 'Casual Shoes', 2),
(26, 'Boys', 10),
(27, 'Girls', 10),
(28, 'Boys', 11),
(29, 'Girls', 11),
(30, 'Boys', 12),
(31, 'Girls', 12),
(32, 'Dresses', 7),
(33, 'Tops', 7),
(34, 'T-Shirts & Vests', 7),
(35, 'Pants & Leggings', 7),
(36, 'Sportswear', 7),
(37, 'Plus Size Clothing', 7),
(38, 'Socks & Hosiery', 7),
(39, 'Fragrance', 3),
(40, 'Skincare', 3),
(41, 'Hair Care', 3),
(42, 'Jewellery', 4),
(43, 'Eyes Care', 3),
(44, 'Lips', 3),
(45, 'Face Care', 3),
(46, 'Gift Sets', 3),
(47, 'Scarves & Headwear', 4),
(48, 'Multipacks', 4),
(49, 'Other Accessories', 4),
(50, 'Pumps', 6),
(51, 'Sneakers', 6),
(52, 'Sports Shoes', 6),
(53, 'Boots', 6),
(54, 'Comfort Shoes', 6),
(55, 'Slippers & Casual Shoes', 6),
(56, 'Formal Shoes', 2),
(57, 'Belts', 1),
(58, 'Multipacks', 1),
(59, 'Other Accessories', 1),
(60, 'Bags', 4),
(61, 'Cell Phone and Accessories', 14),
(62, 'Headphones', 14),
(63, 'Security and Surveillance', 14),
(64, 'Television and Video', 14),
(65, 'GPS and Navigation', 14),
(66, 'Home Audio', 14),
(67, 'Computer Components', 15),
(68, 'Computers and Tablets', 15),
(69, 'Laptop Accessories', 15),
(70, 'Printer and Monitors', 15),
(71, 'External Components', 15),
(72, 'Networking Products', 15),
(73, 'Medical Supplies and Equipment', 16),
(74, 'Oral Care', 16),
(75, 'Vision Care', 16),
(76, 'Vitamins and Dietary Supplements', 16),
(77, 'Baby and Child Care', 17),
(78, 'Household Supplies', 17),
(79, 'Stationery and Gift Wrapping Supplies', 17);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_faq`
--

CREATE TABLE `tbl_faq` (
  `faq_id` int(11) NOT NULL,
  `faq_title` varchar(255) NOT NULL,
  `faq_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_faq`
--

INSERT INTO `tbl_faq` (`faq_id`, `faq_title`, `faq_content`) VALUES
(1, 'How to find an item?', '<h3 class=\"checkout-complete-box font-bold txt16\" style=\"box-sizing: inherit; text-rendering: optimizeLegibility; margin: 0.2rem 0px 0.5rem; padding: 0px; line-height: 1.4; background-color: rgb(250, 250, 250);\"><font color=\"#222222\" face=\"opensans, Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif\"><span style=\"font-size: 15.7143px;\">We have a wide range of fabulous products to choose from.</span></font></h3><h3 class=\"checkout-complete-box font-bold txt16\" style=\"box-sizing: inherit; text-rendering: optimizeLegibility; margin: 0.2rem 0px 0.5rem; padding: 0px; line-height: 1.4; background-color: rgb(250, 250, 250);\"><span style=\"font-size: 15.7143px; color: rgb(34, 34, 34); font-family: opensans, \"Helvetica Neue\", Helvetica, Helvetica, Arial, sans-serif;\">Tip 1: If you\'re looking for a specific product, use the keyword search box located at the top of the site. Simply type what you are looking for, and prepare to be amazed!</span></h3><h3 class=\"checkout-complete-box font-bold txt16\" style=\"box-sizing: inherit; text-rendering: optimizeLegibility; margin: 0.2rem 0px 0.5rem; padding: 0px; line-height: 1.4; background-color: rgb(250, 250, 250);\"><font color=\"#222222\" face=\"opensans, Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif\"><span style=\"font-size: 15.7143px;\">Tip 2: If you want to explore a category of products, use the Shop Categories in the upper menu, and navigate through your favorite categories where we\'ll feature the best products in each.</span></font><br><br></h3>\r\n'),
(2, 'What is your return policy?', '<p><span style=\"color: rgb(10, 10, 10); font-family: opensans, &quot;Helvetica Neue&quot;, Helvetica, Helvetica, Arial, sans-serif; font-size: 14px; text-align: center;\">You have 15 days to make a refund request after your order has been delivered.</span><br></p>\r\n'),
(3, ' I received a defective/damaged item, can I get a refund?', '<p>In case the item you received is damaged or defective, you could return an item in the same condition as you received it with the original box and/or packaging intact. Once we receive the returned item, we will inspect it and if the item is found to be defective or damaged, we will process the refund along with any shipping fees incurred.<br></p>\r\n'),
(4, 'When are ‘Returns’ not possible?', '<p class=\"a  \" style=\"box-sizing: inherit; text-rendering: optimizeLegibility; line-height: 1.6; margin-bottom: 0.714286rem; padding: 0px; font-size: 14px; color: rgb(10, 10, 10); font-family: opensans, &quot;Helvetica Neue&quot;, Helvetica, Helvetica, Arial, sans-serif; background-color: rgb(250, 250, 250);\">There are a few certain scenarios where it is difficult for us to support returns:</p><ol style=\"box-sizing: inherit; line-height: 1.6; margin-right: 0px; margin-bottom: 0px; margin-left: 1.25rem; padding: 0px; list-style-position: outside; color: rgb(10, 10, 10); font-family: opensans, &quot;Helvetica Neue&quot;, Helvetica, Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(250, 250, 250);\"><li style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-size: inherit;\">Return request is made outside the specified time frame, of 15 days from delivery.</li><li style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-size: inherit;\">Product is used, damaged, or is not in the same condition as you received it.</li><li style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-size: inherit;\">Specific categories like innerwear, lingerie, socks and clothing freebies etc.</li><li style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-size: inherit;\">Defective products which are covered under the manufacturer\'s warranty.</li><li style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-size: inherit;\">Any consumable item which has been used or installed.</li><li style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-size: inherit;\">Products with tampered or missing serial numbers.</li><li style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-size: inherit;\">Anything missing from the package you\'ve received including price tags, labels, original packing, freebies and accessories.</li><li style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-size: inherit;\">Fragile items, hygiene related items.</li></ol>\r\n'),
(5, 'What are the items that cannot be returned?', '<p>The items that can not be returned are:</p><p>Clearance items clearly marked as such and displaying a No-Return Policy<br></p><p>When the offer notes states so specifically are items that cannot be returned.</p><p>Items that fall into the below product types-</p><ul><li>Underwear</li><li>Lingerie</li><li>Socks</li><li>Software</li><li>Music albums</li><li>Books</li><li>Swimwear</li><li>Beauty &amp; Fragrances</li><li>Hosiery</li></ul><p>Also, any consumable items that are used or installed cannot be returned. As outlined in consumer Protection Rights and concerning section on non-returnable items<br></p>');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_language`
--

CREATE TABLE `tbl_language` (
  `lang_id` int(11) NOT NULL,
  `lang_name` varchar(255) NOT NULL,
  `lang_value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_language`
--

INSERT INTO `tbl_language` (`lang_id`, `lang_name`, `lang_value`) VALUES
(1, 'Currency', '$'),
(2, 'Search Product', 'Search Product'),
(3, 'Search', 'Search'),
(4, 'Submit', 'Submit'),
(5, 'Update', 'Update'),
(6, 'Read More', 'Read More'),
(7, 'Serial', 'Serial'),
(8, 'Photo', 'Photo'),
(9, 'Login', 'Login'),
(10, 'Customer Login', 'Customer Login'),
(11, 'Click here to login', 'Click here to login'),
(12, 'Back to Login Page', 'Back to Login Page'),
(13, 'Logged in as', 'Logged in as'),
(14, 'Logout', 'Logout'),
(15, 'Register', 'Register'),
(16, 'Customer Registration', 'Customer Registration'),
(17, 'Registration Successful', 'Registration Successful'),
(18, 'Cart', 'Cart'),
(19, 'View Cart', 'View Cart'),
(20, 'Update Cart', 'Update Cart'),
(21, 'Back to Cart', 'Back to Cart'),
(22, 'Checkout', 'Checkout'),
(23, 'Proceed to Checkout', 'Proceed to Checkout'),
(24, 'Orders', 'Orders'),
(25, 'Order History', 'Order History'),
(26, 'Order Details', 'Order Details'),
(27, 'Payment Date and Time', 'Payment Date and Time'),
(28, 'Transaction ID', 'Transaction ID'),
(29, 'Paid Amount', 'Paid Amount'),
(30, 'Payment Status', 'Payment Status'),
(31, 'Payment Method', 'Payment Method'),
(32, 'Payment ID', 'Payment ID'),
(33, 'Payment Section', 'Payment Section'),
(34, 'Select Payment Method', 'Select Payment Method'),
(35, 'Select a Method', 'Select a Method'),
(36, 'PayPal', 'PayPal'),
(37, 'Stripe', 'Stripe'),
(38, 'Bank Deposit', 'Bank Deposit'),
(39, 'Card Number', 'Card Number'),
(40, 'CVV', 'CVV'),
(41, 'Month', 'Month'),
(42, 'Year', 'Year'),
(43, 'Send to this Details', 'Send to this Details'),
(44, 'Transaction Information', 'Transaction Information'),
(45, 'Include transaction id and other information correctly', 'Include transaction id and other information correctly'),
(46, 'Pay Now', 'Pay Now'),
(47, 'Product Name', 'Product Name'),
(48, 'Product Details', 'Product Details'),
(49, 'Categories', 'Categories'),
(50, 'Category:', 'Category:'),
(51, 'All Products Under', 'All Products Under'),
(52, 'Select Size', 'Select Size'),
(53, 'Select Color', 'Select Color'),
(54, 'Product Price', 'Product Price'),
(55, 'Quantity', 'Quantity'),
(56, 'Out of Stock', 'Out of Stock'),
(57, 'Share This', 'Share This'),
(58, 'Share This Product', 'Share This Product'),
(59, 'Product Description', 'Product Description'),
(60, 'Features', 'Features'),
(61, 'Conditions', 'Conditions'),
(62, 'Return Policy', 'Return Policy'),
(63, 'Reviews', 'Reviews'),
(64, 'Review', 'Review'),
(65, 'Give a Review', 'Give a Review'),
(66, 'Write your comment (Optional)', 'Write your comment (Optional)'),
(67, 'Submit Review', 'Submit Review'),
(68, 'You already have given a rating!', 'You already have given a rating!'),
(69, 'You must have to login to give a review', 'You must have to login to give a review'),
(70, 'No description found', 'No description found'),
(71, 'No feature found', 'No feature found'),
(72, 'No condition found', 'No condition found'),
(73, 'No return policy found', 'No return policy found'),
(74, 'Review not found', 'Review not found'),
(75, 'Customer Name', 'Customer Name'),
(76, 'Comment', 'Comment'),
(77, 'Comments', 'Comments'),
(78, 'Rating', 'Rating'),
(79, 'Previous', 'Previous'),
(80, 'Next', 'Next'),
(81, 'Sub Total', 'Sub Total'),
(82, 'Total', 'Total'),
(83, 'Action', 'Action'),
(84, 'Shipping Cost', 'Shipping Cost'),
(85, 'Continue Shopping', 'Continue Shopping'),
(86, 'Update Billing Address', 'Update Billing Address'),
(87, 'Update Shipping Address', 'Update Shipping Address'),
(88, 'Update Billing and Shipping Info', 'Update Billing and Shipping Info'),
(89, 'Dashboard', 'Dashboard'),
(90, 'Welcome to the Dashboard', 'Welcome to the Dashboard'),
(91, 'Back to Dashboard', 'Back to Dashboard'),
(92, 'Subscribe', 'Subscribe'),
(93, 'Subscribe To Our Newsletter', 'Subscribe To Our Newsletter'),
(94, 'Email Address', 'Email Address'),
(95, 'Enter Your Email Address', 'Enter Your Email Address'),
(96, 'Password', 'Password'),
(97, 'Forget Password', 'Forget Password'),
(98, 'Retype Password', 'Retype Password'),
(99, 'Update Password', 'Update Password'),
(100, 'New Password', 'New Password'),
(101, 'Retype New Password', 'Retype New Password'),
(102, 'Full Name', 'Full Name'),
(103, 'Company Name', 'Company Name'),
(104, 'Phone Number', 'Phone Number'),
(105, 'Address', 'Address'),
(106, 'Country', 'Country'),
(107, 'City', 'City'),
(108, 'State', 'State'),
(109, 'Zip Code', 'Zip Code'),
(110, 'About Us', 'About Us'),
(111, 'Featured Posts', 'Featured Posts'),
(112, 'Popular Posts', 'Popular Posts'),
(113, 'Recent Posts', 'Recent Posts'),
(114, 'Contact Information', 'Contact Information'),
(115, 'Contact Form', 'Contact Form'),
(116, 'Our Office', 'Our Office'),
(117, 'Update Profile', 'Update Profile'),
(118, 'Send Message', 'Send Message'),
(119, 'Message', 'Message'),
(120, 'Find Us On Map', 'Find Us On Map'),
(121, 'Congratulation! Payment is successful.', 'Congratulation! Payment is successful.'),
(122, 'Billing and Shipping Information is updated successfully.', 'Billing and Shipping Information is updated successfully.'),
(123, 'Customer Name can not be empty.', 'Customer Name can not be empty.'),
(124, 'Phone Number can not be empty.', 'Phone Number can not be empty.'),
(125, 'Address can not be empty.', 'Address can not be empty.'),
(126, 'You must have to select a country.', 'You must have to select a country.'),
(127, 'City can not be empty.', 'City can not be empty.'),
(128, 'State can not be empty.', 'State can not be empty.'),
(129, 'Zip Code can not be empty.', 'Zip Code can not be empty.'),
(130, 'Profile Information is updated successfully.', 'Profile Information is updated successfully.'),
(131, 'Email Address can not be empty', 'Email Address can not be empty'),
(132, 'Email and/or Password can not be empty.', 'Email and/or Password can not be empty.'),
(133, 'Email Address does not match.', 'Email Address does not match.'),
(134, 'Email address must be valid.', 'Email address must be valid.'),
(135, 'You email address is not found in our system.', 'You email address is not found in our system.'),
(136, 'Please check your email and confirm your subscription.', 'Please check your email and confirm your subscription.'),
(137, 'Your email is verified successfully. You can now login to our website.', 'Your email is verified successfully. You can now login to our website.'),
(138, 'Password can not be empty.', 'Password can not be empty.'),
(139, 'Passwords do not match.', 'Passwords do not match.'),
(140, 'Please enter new and retype passwords.', 'Please enter new and retype passwords.'),
(141, 'Password is updated successfully.', 'Password is updated successfully.'),
(142, 'To reset your password, please click on the link below.', 'To reset your password, please click on the link below.'),
(143, 'PASSWORD RESET REQUEST - YOUR WEBSITE.COM', 'PASSWORD RESET REQUEST - YOUR WEBSITE.COM'),
(144, 'The password reset email time (24 hours) has expired. Please again try to reset your password.', 'The password reset email time (24 hours) has expired. Please again try to reset your password.'),
(145, 'A confirmation link is sent to your email address. You will get the password reset information in there.', 'A confirmation link is sent to your email address. You will get the password reset information in there.'),
(146, 'Password is reset successfully. You can now login.', 'Password is reset successfully. You can now login.'),
(147, 'Email Address Already Exists', 'Email Address Already Exists.'),
(148, 'Sorry! Your account is inactive. Please contact to the administrator.', 'Sorry! Your account is inactive. Please contact to the administrator.'),
(149, 'Change Password', 'Change Password'),
(150, 'Registration Email Confirmation for YOUR WEBSITE', 'Registration Email Confirmation for YOUR WEBSITE.'),
(151, 'Thank you for your registration! Your account has been created. To active your account click on the link below:', 'Thank you for your registration! Your account has been created. To active your account click on the link below:'),
(152, 'Your registration is completed. Please check your email address to follow the process to confirm your registration.', 'Your registration is completed. Please check your email address to follow the process to confirm your registration.'),
(153, 'No Product Found', 'No Product Found'),
(154, 'Add to Cart', 'Add to Cart'),
(155, 'Related Products', 'Related Products'),
(156, 'See all related products from below', 'See all the related products from below'),
(157, 'Size', 'Size'),
(158, 'Color', 'Color'),
(159, 'Price', 'Price'),
(160, 'Please login as customer to checkout', 'Please login as customer to checkout'),
(161, 'Billing Address', 'Billing Address'),
(162, 'Shipping Address', 'Shipping Address'),
(163, 'Rating is Submitted Successfully!', 'Rating is Submitted Successfully!');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mid_category`
--

CREATE TABLE `tbl_mid_category` (
  `mcat_id` int(11) NOT NULL,
  `mcat_name` varchar(255) NOT NULL,
  `tcat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_mid_category`
--

INSERT INTO `tbl_mid_category` (`mcat_id`, `mcat_name`, `tcat_id`) VALUES
(1, 'Men Accessories', 1),
(2, 'Men\'s Shoes', 1),
(3, 'Beauty Products', 2),
(4, 'Accessories', 2),
(6, 'Shoes', 2),
(7, 'Clothing', 2),
(8, 'Bottoms', 1),
(9, 'T-shirts & Shirts', 1),
(10, 'Clothing', 3),
(11, 'Shoes', 3),
(12, 'Accessories', 3),
(14, 'Electronic Items', 4),
(15, 'Computers', 4),
(16, 'Health', 5),
(17, 'Household', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `size` varchar(100) NOT NULL,
  `color` varchar(100) NOT NULL,
  `quantity` varchar(50) NOT NULL,
  `unit_price` varchar(50) NOT NULL,
  `payment_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`id`, `product_id`, `product_name`, `size`, `color`, `quantity`, `unit_price`, `payment_id`) VALUES
(35, 118, 'BAGMODE Women\'s Classic Top Handle Handbag, White Leather with Gold Hardware, Crossbody Strap', '', '', '1', '8000', '1754227778'),
(37, 111, 'Ray-Ban Junior Unisex Round Sunglasses - 0RJ9547S', '', '', '1', '4399', '1754284809'),
(38, 115, 'Kvetoo V Neck Sleeveless Winter Wool Sweater for Men', '', '', '1', '3999', '1754312655'),
(40, 112, 'Sylvi Timegrapher Luxury Business Casual Party-Wear Leather Strap Chronograph Date Display Watch for Men | Working Chronograph Watch for Men - 556 Blue RG Leather', '', '', '1', '1428', '1754371014');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_page`
--

CREATE TABLE `tbl_page` (
  `id` int(11) NOT NULL,
  `about_title` varchar(255) NOT NULL,
  `about_content` text NOT NULL,
  `about_banner` varchar(255) NOT NULL,
  `about_meta_title` text NOT NULL,
  `about_meta_keyword` text NOT NULL,
  `about_meta_description` text NOT NULL,
  `faq_title` varchar(255) NOT NULL,
  `faq_banner` varchar(255) NOT NULL,
  `faq_meta_title` text NOT NULL,
  `faq_meta_keyword` text NOT NULL,
  `faq_meta_description` text NOT NULL,
  `blog_title` varchar(255) NOT NULL,
  `blog_banner` varchar(255) NOT NULL,
  `blog_meta_title` text NOT NULL,
  `blog_meta_keyword` text NOT NULL,
  `blog_meta_description` text NOT NULL,
  `contact_title` varchar(255) NOT NULL,
  `contact_banner` varchar(255) NOT NULL,
  `contact_meta_title` text NOT NULL,
  `contact_meta_keyword` text NOT NULL,
  `contact_meta_description` text NOT NULL,
  `pgallery_title` varchar(255) NOT NULL,
  `pgallery_banner` varchar(255) NOT NULL,
  `pgallery_meta_title` text NOT NULL,
  `pgallery_meta_keyword` text NOT NULL,
  `pgallery_meta_description` text NOT NULL,
  `vgallery_title` varchar(255) NOT NULL,
  `vgallery_banner` varchar(255) NOT NULL,
  `vgallery_meta_title` text NOT NULL,
  `vgallery_meta_keyword` text NOT NULL,
  `vgallery_meta_description` text NOT NULL,
  `tnc_title` varchar(255) NOT NULL DEFAULT '',
  `tnc_content` text NOT NULL,
  `tnc_banner` varchar(255) NOT NULL DEFAULT '',
  `tnc_meta_title` text NOT NULL DEFAULT '',
  `tnc_meta_keyword` text NOT NULL,
  `tnc_meta_description` text NOT NULL,
  `shipping_title` varchar(255) NOT NULL DEFAULT '',
  `shipping_content` text NOT NULL,
  `shipping_banner` varchar(255) NOT NULL DEFAULT '',
  `shipping_meta_title` text NOT NULL DEFAULT '',
  `shipping_meta_keyword` text NOT NULL,
  `shipping_meta_description` text NOT NULL,
  `privacy_title` varchar(255) NOT NULL DEFAULT '',
  `privacy_content` text NOT NULL,
  `privacy_banner` varchar(255) NOT NULL DEFAULT '',
  `privacy_meta_title` text NOT NULL DEFAULT '',
  `privacy_meta_keyword` text NOT NULL,
  `privacy_meta_description` text NOT NULL,
  `seller_tnc_title` varchar(255) DEFAULT NULL,
  `seller_tnc_content` text DEFAULT NULL,
  `seller_tnc_banner` varchar(255) DEFAULT NULL,
  `seller_tnc_meta_title` text DEFAULT NULL,
  `seller_tnc_meta_keyword` text DEFAULT NULL,
  `seller_tnc_meta_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_page`
--

INSERT INTO `tbl_page` (`id`, `about_title`, `about_content`, `about_banner`, `about_meta_title`, `about_meta_keyword`, `about_meta_description`, `faq_title`, `faq_banner`, `faq_meta_title`, `faq_meta_keyword`, `faq_meta_description`, `blog_title`, `blog_banner`, `blog_meta_title`, `blog_meta_keyword`, `blog_meta_description`, `contact_title`, `contact_banner`, `contact_meta_title`, `contact_meta_keyword`, `contact_meta_description`, `pgallery_title`, `pgallery_banner`, `pgallery_meta_title`, `pgallery_meta_keyword`, `pgallery_meta_description`, `vgallery_title`, `vgallery_banner`, `vgallery_meta_title`, `vgallery_meta_keyword`, `vgallery_meta_description`, `tnc_title`, `tnc_content`, `tnc_banner`, `tnc_meta_title`, `tnc_meta_keyword`, `tnc_meta_description`, `shipping_title`, `shipping_content`, `shipping_banner`, `shipping_meta_title`, `shipping_meta_keyword`, `shipping_meta_description`, `privacy_title`, `privacy_content`, `privacy_banner`, `privacy_meta_title`, `privacy_meta_keyword`, `privacy_meta_description`, `seller_tnc_title`, `seller_tnc_content`, `seller_tnc_banner`, `seller_tnc_meta_title`, `seller_tnc_meta_keyword`, `seller_tnc_meta_description`) VALUES
(1, 'About Us', '<p style=\"border: 0px solid; margin-top: 1.5rem; margin-bottom: 0px;\">Welcome to E-martz, your one-stop online marketplace designed to meet the diverse needs of modern shoppers. Founded with the vision of making quality products accessible to everyone, E-martz has quickly grown into a trusted e-commerce platform that values convenience, reliability, and customer satisfaction above all.</p><p style=\"border: 0px solid; margin-top: 1.5rem; margin-bottom: 0px;\"><br></p><p style=\"border: 0px solid; margin-top: 1.5rem; margin-bottom: 0px;\">At E-martz, we offer a carefully curated selection of products ranging from electronics, fashion, and home essentials to health and beauty, groceries, and more. Our goal is to provide a seamless and enjoyable shopping experience, backed by a user-friendly interface, secure payment methods, and fast, reliable delivery services. Whether you\'re looking for everyday necessities or unique finds, we make it easy to browse, compare, and purchase from the comfort of your home.</p><p style=\"border: 0px solid; margin-top: 1.5rem; margin-bottom: 0px;\"><br></p><p style=\"border: 0px solid; margin-top: 1.5rem; margin-bottom: 0px;\">We believe that online shopping should be more than just a transaction — it should be an experience. That’s why we are committed to maintaining high standards of quality across all our offerings, working with trusted suppliers and partners to ensure that every product meets your expectations. Our dedicated customer support team is always ready to assist you with any queries or concerns, ensuring that your satisfaction is our top priority.</p><p style=\"border: 0px solid; margin-top: 1.5rem; margin-bottom: 0px;\"><br></p><p style=\"border: 0px solid; margin-top: 1.5rem; margin-bottom: 0px;\">As we continue to grow, E-martz remains focused on innovation, customer-centric service, and social responsibility. We aim to become not just a marketplace, but a meaningful part of your daily life.</p><p style=\"border: 0px solid; margin-top: 1.5rem; margin-bottom: 0px;\"><br></p><p style=\"border: 0px solid; margin-top: 1.5rem; margin-bottom: 0px;\">Thank you for choosing E-martz. We look forward to serving you today and in the future.</p><p style=\"border: 0px solid; margin-top: 1.5rem; margin-bottom: 0px;\"></p>', 'about-banner.jpg', 'E-Martz - About Us', 'about, about us, about fashion, about company, about ecommerce php project', 'Our goal has always been to get the best in you we brought a huge collection whether youâ€™re attending a party, wedding, and all those events that require a WOW dress.', 'FAQ', 'faq-banner.jpg', 'E-martz.com - FAQ', '? Account & Security\r\n1. How do I register on E-martz?\r\nClick the \"Register\" button on the homepage and fill in your name, email, and password. After submitting the form, you’ll receive a confirmation email to activate your account.\r\n\r\n2. I forgot my password. How can I reset it?\r\nGo to the Login Page and click on “Forgot Password”. Enter your email address to receive a reset link.\r\n\r\n3. Is my data safe on E-martz?\r\nAbsolutely. We use SSL encryption and secure servers to protect all personal and payment information.\r\n\r\n? Shopping & Orders\r\n4. How do I place an order?\r\nBrowse products, add your selections to the cart, and proceed to checkout. Fill in your billing and shipping details, choose a payment method, and confirm your order.\r\n\r\n5. Can I modify or cancel an order after placing it?\r\nOrders can only be changed or canceled before they are shipped. Please contact our support team as soon as possible.\r\n\r\n6. What should I do if a product is out of stock?\r\nYou can click “Notify Me” on the product page to receive an alert when it\'s back in stock.\r\n', '? Payments & Billing\r\n7. What payment methods are accepted?\r\nWe accept:\r\n\r\nCredit/Debit cards (Visa, MasterCard, etc.)\r\n\r\nOnline banking\r\n\r\nE-wallets like PayPal and local payment gateways (if supported)\r\n\r\n8. Is Cash on Delivery (COD) available?\r\nYes, COD is available for select products and regions. You’ll see the option during checkout if it’s supported in your area.\r\n\r\n9. Why was my payment declined?\r\nThere could be multiple reasons: incorrect card info, insufficient funds, or bank restrictions. Please try again or use a different payment method.\r\n\r\n? Shipping & Delivery\r\n10. How long does delivery take?\r\nOrders are typically delivered within 3–7 business days, depending on your location.\r\n\r\n11. How do I track my order?\r\nLog in to your account, go to the \"My Orders\" section, and click on the order you want to track.\r\n\r\n12. Do you offer international shipping?\r\nCurrently, we only deliver within [your operating region]. International shipping may be available in the future.\r\n\r\n? Returns & Refunds\r\n13. What is your return policy?\r\nYou can return eligible products within 7–14 days of delivery. Items must be unused and in original packaging.\r\n\r\n14. How do I request a return?\r\nGo to your order history, select the item, and click on “Request Return”. Follow the instructions provided.\r\n\r\n15. When will I get my refund?\r\nRefunds are processed within 5–10 business days after we receive the returned item.\r\n\r\n? Customer Support\r\n16. How can I contact customer service?\r\nYou can:\r\n\r\nUse our Contact Form\r\n\r\nEmail: support@emartz.com\r\n\r\nCall: +123-456-7890 (9 AM – 6 PM, Mon–Fri)\r\n\r\n17. Where can I find updates or announcements?\r\nWe post updates on the homepage banner and notify users via email.\r\n\r\n?? Other Questions\r\n18. Do you offer warranties on products?\r\nSome products come with manufacturer warranties. Check the product description for warranty details.\r\n\r\n19. Can I save items to purchase later?\r\nYes, use the Wishlist feature to save your favorite products for future purchases.\r\n\r\n20. Do you offer promotions or discounts?\r\nYes! We regularly run sales and offer promo codes. Subscribe to our newsletter to stay updated.\r\n\r\n', 'Blog', 'blog-banner.jpg', 'Ecommerce - Blog', '', '', 'Contact Us', 'contact-banner.jpg', 'E-martz.com - Contact', '', '', 'Photo Gallery', 'pgallery-banner.jpg', 'Ecommerce - Photo Gallery', '', '', 'Video Gallery', 'vgallery-banner.jpg', 'Ecommerce - Video Gallery', '', '', 'Terms & Conditions', '<div>Welcome to E-martz. By accessing or using our website, you agree to be bound by the following Terms &amp; Conditions. These terms apply to all users of the site, including without limitation users who are browsers, vendors, customers, merchants, and/or contributors of content.</div><div><br></div><div>All products and services provided on this website are subject to availability and may be withdrawn or modified at any time without notice. Prices are subject to change without prior notice. We strive to ensure that all product descriptions, prices, and images are accurate; however, errors may occur. In such cases, we reserve the right to correct any errors and to cancel orders if necessary.</div><div><br></div><div>Users are responsible for maintaining the confidentiality of their account credentials. E-martz is not liable for any loss or damage resulting from unauthorized access to your account. By placing an order, you confirm that you are legally capable of entering into binding contracts.</div><div><br></div><div>We reserve the right to refuse service, terminate accounts, or cancel orders at our sole discretion, especially in cases of suspected fraud or violation of our policies. Returns and refunds are subject to our Return Policy, which can be reviewed separately on our website.</div><div><br></div><div>E-martz may update these Terms &amp; Conditions at any time, and continued use of the website following any changes indicates your acceptance of those changes. We encourage you to review this page regularly to stay informed of any updates.</div><div><br></div><div>If you have any questions regarding these terms, please contact our support team via the Contact Us page.</div><div><br></div>', 'tnc-banner.jpg', 'E-Martz -Terms & Conditions', 'about, about us, about fashion, about company, about ecommerce php project', 'Our goal has always been to get the best in you we brought a huge collection whether youâ€™re attending a party, wedding, and all those events that require a WOW dress.', 'Shipping & Returns', '<p>At E-martz, we aim to deliver your orders swiftly, safely, and accurately. Below is our standard shipping and return policy to ensure transparency and customer satisfaction.</p><p>Shipping Policy:</p><p><br></p><p>&nbsp; &nbsp; &nbsp;We process and ship orders within 1–2 business days after payment confirmation.</p><p><br></p><p>&nbsp; &nbsp; &nbsp;Standard shipping usually takes 3–7 business days depending on your location.</p><p><br></p><p>&nbsp; &nbsp; &nbsp;You will receive a tracking number via email once your order has been dispatched.</p><p><br></p><p>&nbsp; &nbsp; &nbsp;We currently ship within INDIA only. For international orders, please contact our support team before placing an order.</p><p><br></p><p>&nbsp; &nbsp; &nbsp;Shipping charges are calculated at checkout based on location and order weight.</p><p><br></p><p>Returns &amp; Exchanges:</p><p><br></p><p>&nbsp; &nbsp; If you\'re not satisfied with your purchase, you may return it within 7 days of delivery for a full refund or exchange, provided the item is unused and in its original&nbsp; &nbsp; &nbsp;packaging.</p><p><br></p><p>&nbsp; &nbsp;Customers are responsible for return shipping costs unless the item received was damaged or incorrect.</p><p><br></p><p>&nbsp; &nbsp; Refunds will be processed within 5–10 business days after we receive the returned product.</p><p><br></p><p>&nbsp; &nbsp; Certain products (e.g., perishables, personal care items, or digital goods) may not be eligible for return. Please check product descriptions for return eligibility.</p><p><br></p><p>Damaged or Wrong Items:</p><p><br></p><p>&nbsp; &nbsp;If you receive a defective or incorrect product, please contact us within 48 hours of delivery. We\'ll arrange for a replacement or refund at no extra cost.</p><p><br></p><p>Need Help?</p><p>&nbsp; &nbsp;For any issues regarding shipping or returns, please reach out to our customer service team via the Contact Us page or email us at support@emartz.com.</p><p><br></p><p><br></p>', 'shipping-banner.jpg', 'E-martz - Shipping & Returns', '', '', 'Privacy Policy', '<div>&nbsp; &nbsp;At E-martz, we value your privacy and are committed to protecting your personal information. This Privacy Policy outlines how we collect, use, and safeguard your data when you visit our website or make a purchase.</div><div><br></div><div>1. Information We Collect</div><div>We may collect the following types of information:</div><div><br></div><div>&nbsp; &nbsp;Personal details (name, email, phone number, address) during account registration or checkout.</div><div><br></div><div>&nbsp; &nbsp;Payment information when processing transactions.</div><div><br></div><div>&nbsp; &nbsp;Browsing activity, IP address, and device information to enhance your shopping experience.</div><div><br></div><div>2. How We Use Your Information</div><div>We use the information we collect to:</div><div><br></div><div>&nbsp; &nbsp;Process orders and deliver products to you.</div><div><br></div><div>&nbsp; &nbsp;Communicate order updates and respond to customer inquiries.</div><div><br></div><div>&nbsp; &nbsp;Improve our website, products, and services.</div><div><br></div><div>&nbsp; &nbsp;Send promotional emails (only if you’ve opted in).</div><div><br></div><div>3. Data Protection</div><div>&nbsp; &nbsp;We implement appropriate security measures to protect your personal data from unauthorized access, disclosure, or alteration. All payment transactions are encrypted and processed through secure gateways.</div><div><br></div><div>4. Sharing of Information</div><div>We do not sell or rent your personal information to third parties. However, we may share your data with:</div><div><br></div><div>&nbsp; &nbsp;Trusted service providers for delivery and payment processing.</div><div><br></div><div>&nbsp; &nbsp;Law enforcement or legal entities if required by law.</div><div><br></div><div>5. Cookies</div><div>&nbsp; &nbsp;E-martz uses cookies to enhance site functionality and user experience. Cookies help us remember your preferences and improve future visits. You can disable cookies in your browser settings at any time.</div><div><br></div><div>6. Your Rights</div><div>You have the right to:</div><div><br></div><div>&nbsp; &nbsp;Access, update, or delete your personal information.</div><div><br></div><div>&nbsp; &nbsp;Opt out of promotional communications.</div><div><br></div><div>&nbsp; &nbsp;Request a copy of the data we hold about you.</div><div><br></div><div>7. Changes to This Policy</div><div>&nbsp; &nbsp;We may update this Privacy Policy from time to time. Any changes will be posted on this page with a revised effective date. We encourage you to review it regularly.</div><div><br></div><div>8. Contact Us</div><div>&nbsp; &nbsp;If you have any questions or concerns about this Privacy Policy, please contact us at:</div><div>&nbsp; ? support@emartz.com</div><div>&nbsp; ? [Insert phone number]</div><div><br></div><div><br></div><div><br></div><div><br></div><div><br></div><div><br></div>', 'privacy-banner.jpg', 'E-martz - Privacy Policy', '', '', 'seller t&cs', '<div>? Seller Terms and Conditions – E-martz</div><div><br></div><div>1. Seller Registration :</div><div><br></div><div>Sellers must provide accurate and verifiable business information during registration.</div><div>E-martz reserves the right to approve or reject any seller application without providing a reason.</div><div><br></div><div>2. Product Listing :</div><div><br></div><div>All product details (name, price, description, images) must be true and accurate.</div><div>Listings are subject to admin review and approval before going live.</div><div>Counterfeit, restricted, or prohibited items are strictly not allowed.</div><div><br></div><div>3. Order Fulfillment :</div><div><br></div><div>Sellers are expected to fulfill orders within the time frame mentioned on the product page.</div><div>Failure to fulfill or delayed deliveries may result in penalties or account suspension.</div><div><br></div><div>4. Shipping &amp; Delivery :</div><div><br></div><div>Shipping charges and logistics are managed by E-martz or as per mutual agreement.</div><div>Sellers are responsible for proper packaging to prevent damage in transit.</div><div><br></div><div>5. Commission and Payments :</div><div><br></div><div>E-martz charges a commission on each successful order. The rate will be communicated at onboarding.</div><div>Payouts to sellers will be made weekly/monthly after deduction of commission and any applicable fees.</div><div><br></div><div>6. Returns and Refunds :</div><div><br></div><div>Products eligible for return must be accepted as per the platform’s return policy.</div><div>In case of disputes, E-martz’s decision will be final.</div><div><br></div><div>7. Seller Responsibilities :</div><div><br></div><div>Maintain stock availability and timely updates.</div><div>Respond promptly to customer and admin communications.</div><div>Maintain high-quality service and abide by E-martz policies.</div><div><br></div><div>8. Account Termination :</div><div><br></div><div>E-martz reserves the right to suspend or terminate any seller account found violating these terms, without prior notice.</div><div><br></div><div>9. Modification of Terms :</div><div><br></div><div>E-martz may modify these terms at any time. Continued use of the platform implies agreement to updated terms.</div><div><br></div>', 'seller-tnc-banner.jpg', 'seller t&cs', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment`
--

CREATE TABLE `tbl_payment` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `payment_date` varchar(50) NOT NULL,
  `txnid` varchar(255) NOT NULL,
  `paid_amount` int(11) NOT NULL,
  `card_number` varchar(50) NOT NULL,
  `card_cvv` varchar(10) NOT NULL,
  `card_month` varchar(10) NOT NULL,
  `card_year` varchar(10) NOT NULL,
  `bank_transaction_info` text NOT NULL,
  `payment_method` varchar(20) NOT NULL,
  `payment_status` varchar(25) NOT NULL,
  `shipping_status` varchar(20) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `invoice_number` varchar(20) DEFAULT NULL,
  `tracking_id` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_payment`
--

INSERT INTO `tbl_payment` (`id`, `customer_id`, `customer_name`, `customer_email`, `payment_date`, `txnid`, `paid_amount`, `card_number`, `card_cvv`, `card_month`, `card_year`, `bank_transaction_info`, `payment_method`, `payment_status`, `shipping_status`, `payment_id`, `invoice_number`, `tracking_id`) VALUES
(98, 24, 'Chavda Mehul', 'chavdamehul105@gmail.com', '2025-08-03 06:29:38', 'pay_R0sWmUVdu9v4I7', 8000, '', '', '', '', 'Razorpay Payment ID: pay_R0sWmUVdu9v4I7', 'Razorpay', 'Completed', 'Completed', '1754227778', 'INV00000098', 'TRK20250803533422'),
(100, 24, 'Chavda Mehul', 'chavdamehul105@gmail.com', '2025-08-03 22:20:09', 'pay_R18ipwHE38mUUA', 4399, '', '', '', '', 'Razorpay Payment ID: pay_R18ipwHE38mUUA', 'Razorpay', 'Completed', 'Completed', '1754284809', 'INV00000100', 'TRK20250803777601'),
(101, 26, 'nand', 'nandpatel712005@gmail.com', '2025-08-04 06:04:15', 'pay_R1Gd4ahyfzoX8Z', 3999, '', '', '', '', 'Razorpay Payment ID: pay_R1Gd4ahyfzoX8Z', 'Razorpay', 'Completed', 'Completed', '1754312655', 'INV00000101', 'TRK20250804366547'),
(103, 24, 'Chavda Mehul', 'chavdamehul105@gmail.com', '2025-08-04 22:16:54', 'COD_1754371014_24', 1428, '', '', '', '', 'Cash on Delivery - Order ID: COD_1754371014_24', 'Cash on Delivery', 'Pending', 'Pending', '1754371014', 'INV00000103', 'TRK20250804083901');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_photo`
--

CREATE TABLE `tbl_photo` (
  `id` int(11) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_photo`
--

INSERT INTO `tbl_photo` (`id`, `caption`, `photo`) VALUES
(1, 'Photo 1', 'photo-1.jpg'),
(2, 'Photo 2', 'photo-2.jpg'),
(3, 'Photo 3', 'photo-3.jpg'),
(4, 'Photo 4', 'photo-4.jpg'),
(5, 'Photo 5', 'photo-5.jpg'),
(6, 'Photo 6', 'photo-6.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_post`
--

CREATE TABLE `tbl_post` (
  `post_id` int(11) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_slug` varchar(255) NOT NULL,
  `post_content` text NOT NULL,
  `post_date` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `total_view` int(11) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keyword` text NOT NULL,
  `meta_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_post`
--

INSERT INTO `tbl_post` (`post_id`, `post_title`, `post_slug`, `post_content`, `post_date`, `photo`, `category_id`, `total_view`, `meta_title`, `meta_keyword`, `meta_description`) VALUES
(1, 'Cu vel choro exerci pri et oratio iisque', 'cu-vel-choro-exerci-pri-et-oratio-iisque', '<p>Lorem ipsum dolor sit amet, qui case probo velit no, an postea scaevola partiendo mei. Id mea fuisset perpetua referrentur. Ut everti ceteros mei, alii discere eum no, duo id malis iuvaret. Ad sint everti accusam vel, ea viderer suscipiantur pri. Brute option minimum in cum, ignota iuvaret an pro.</p>\r\n\r\n<p>Solum atqui intellegebat mea an. Ne ius alterum aliquam. Ea nec populo aliquid mentitum, vis in meliore atomorum, sanctus consequat vituperatoribus duo ea. Ad doctus pertinacia ius, virtute fuisset id has, eum ut modo principes. Qui eu labore adversarium, oporteat delicata qui ut, an qui meliore principes. Id aliquid dolorum nam.</p>\r\n\r\n<p>Reque pericula philosophia ut mei, volumus eligendi mandamus has an. In nobis consulatu pri, has at timeam scaevola, has simul quaeque et. Te nec sale accumsan. Dolorem prodesset efficiendi sea ea.</p>\r\n\r\n<p>Et habeo modus debitis pri, vel quis fierent albucius ne. Ea animal meliore usu, nec etiam dolorum atomorum at, nam in audire mandamus omittantur. Cu ius dicam officiis molestiae, mea volumus officiis cotidieque no. Ut vel possim interpretaris, idque probatus antiopam has ad. Facilisi qualisque te sea, no dolorum mnesarchum usu.</p>\r\n\r\n<p>Eum tota graeci impetus an, eirmod invenire rationibus ne mel. Ignota habemus eum ex, vis omnesque delicata perpetua an. Sit id modo invidunt sapientem, ne eum vocibus dolores phaedrum. Case praesent appellantur eu per.</p>\r\n', '05-09-2017', 'news-1.jpg', 3, 14, 'Cu vel choro exerci pri et oratio iisque', '', ''),
(2, 'Epicurei necessitatibus eu facilisi postulant ', 'epicurei-necessitatibus-eu-facilisi-postulant-', '<p>Lorem ipsum dolor sit amet, qui case probo velit no, an postea scaevola partiendo mei. Id mea fuisset perpetua referrentur. Ut everti ceteros mei, alii discere eum no, duo id malis iuvaret. Ad sint everti accusam vel, ea viderer suscipiantur pri. Brute option minimum in cum, ignota iuvaret an pro.</p>\r\n\r\n<p>Solum atqui intellegebat mea an. Ne ius alterum aliquam. Ea nec populo aliquid mentitum, vis in meliore atomorum, sanctus consequat vituperatoribus duo ea. Ad doctus pertinacia ius, virtute fuisset id has, eum ut modo principes. Qui eu labore adversarium, oporteat delicata qui ut, an qui meliore principes. Id aliquid dolorum nam.</p>\r\n\r\n<p>Reque pericula philosophia ut mei, volumus eligendi mandamus has an. In nobis consulatu pri, has at timeam scaevola, has simul quaeque et. Te nec sale accumsan. Dolorem prodesset efficiendi sea ea.</p>\r\n\r\n<p>Et habeo modus debitis pri, vel quis fierent albucius ne. Ea animal meliore usu, nec etiam dolorum atomorum at, nam in audire mandamus omittantur. Cu ius dicam officiis molestiae, mea volumus officiis cotidieque no. Ut vel possim interpretaris, idque probatus antiopam has ad. Facilisi qualisque te sea, no dolorum mnesarchum usu.</p>\r\n\r\n<p>Eum tota graeci impetus an, eirmod invenire rationibus ne mel. Ignota habemus eum ex, vis omnesque delicata perpetua an. Sit id modo invidunt sapientem, ne eum vocibus dolores phaedrum. Case praesent appellantur eu per.</p>\r\n', '05-09-2017', 'news-2.jpg', 3, 6, 'Epicurei necessitatibus eu facilisi postulant ', '', ''),
(3, 'Mei ut errem legimus periculis eos liber', 'mei-ut-errem-legimus-periculis-eos-liber', '<p>Lorem ipsum dolor sit amet, qui case probo velit no, an postea scaevola partiendo mei. Id mea fuisset perpetua referrentur. Ut everti ceteros mei, alii discere eum no, duo id malis iuvaret. Ad sint everti accusam vel, ea viderer suscipiantur pri. Brute option minimum in cum, ignota iuvaret an pro.</p>\r\n\r\n<p>Solum atqui intellegebat mea an. Ne ius alterum aliquam. Ea nec populo aliquid mentitum, vis in meliore atomorum, sanctus consequat vituperatoribus duo ea. Ad doctus pertinacia ius, virtute fuisset id has, eum ut modo principes. Qui eu labore adversarium, oporteat delicata qui ut, an qui meliore principes. Id aliquid dolorum nam.</p>\r\n\r\n<p>Reque pericula philosophia ut mei, volumus eligendi mandamus has an. In nobis consulatu pri, has at timeam scaevola, has simul quaeque et. Te nec sale accumsan. Dolorem prodesset efficiendi sea ea.</p>\r\n\r\n<p>Et habeo modus debitis pri, vel quis fierent albucius ne. Ea animal meliore usu, nec etiam dolorum atomorum at, nam in audire mandamus omittantur. Cu ius dicam officiis molestiae, mea volumus officiis cotidieque no. Ut vel possim interpretaris, idque probatus antiopam has ad. Facilisi qualisque te sea, no dolorum mnesarchum usu.</p>\r\n\r\n<p>Eum tota graeci impetus an, eirmod invenire rationibus ne mel. Ignota habemus eum ex, vis omnesque delicata perpetua an. Sit id modo invidunt sapientem, ne eum vocibus dolores phaedrum. Case praesent appellantur eu per.</p>\r\n', '05-09-2017', 'news-3.jpg', 3, 1, 'Mei ut errem legimus periculis eos liber', '', ''),
(4, 'Id pro unum pertinax oportere vel', 'id-pro-unum-pertinax-oportere-vel', '<p>Lorem ipsum dolor sit amet, qui case probo velit no, an postea scaevola partiendo mei. Id mea fuisset perpetua referrentur. Ut everti ceteros mei, alii discere eum no, duo id malis iuvaret. Ad sint everti accusam vel, ea viderer suscipiantur pri. Brute option minimum in cum, ignota iuvaret an pro.</p>\r\n\r\n<p>Solum atqui intellegebat mea an. Ne ius alterum aliquam. Ea nec populo aliquid mentitum, vis in meliore atomorum, sanctus consequat vituperatoribus duo ea. Ad doctus pertinacia ius, virtute fuisset id has, eum ut modo principes. Qui eu labore adversarium, oporteat delicata qui ut, an qui meliore principes. Id aliquid dolorum nam.</p>\r\n\r\n<p>Reque pericula philosophia ut mei, volumus eligendi mandamus has an. In nobis consulatu pri, has at timeam scaevola, has simul quaeque et. Te nec sale accumsan. Dolorem prodesset efficiendi sea ea.</p>\r\n\r\n<p>Et habeo modus debitis pri, vel quis fierent albucius ne. Ea animal meliore usu, nec etiam dolorum atomorum at, nam in audire mandamus omittantur. Cu ius dicam officiis molestiae, mea volumus officiis cotidieque no. Ut vel possim interpretaris, idque probatus antiopam has ad. Facilisi qualisque te sea, no dolorum mnesarchum usu.</p>\r\n\r\n<p>Eum tota graeci impetus an, eirmod invenire rationibus ne mel. Ignota habemus eum ex, vis omnesque delicata perpetua an. Sit id modo invidunt sapientem, ne eum vocibus dolores phaedrum. Case praesent appellantur eu per.</p>\r\n', '05-09-2017', 'news-4.jpg', 4, 0, 'Id pro unum pertinax oportere vel', '', ''),
(5, 'Tollit cetero cu usu etiam evertitur', 'tollit-cetero-cu-usu-etiam-evertitur', '<p>Lorem ipsum dolor sit amet, qui case probo velit no, an postea scaevola partiendo mei. Id mea fuisset perpetua referrentur. Ut everti ceteros mei, alii discere eum no, duo id malis iuvaret. Ad sint everti accusam vel, ea viderer suscipiantur pri. Brute option minimum in cum, ignota iuvaret an pro.</p>\r\n\r\n<p>Solum atqui intellegebat mea an. Ne ius alterum aliquam. Ea nec populo aliquid mentitum, vis in meliore atomorum, sanctus consequat vituperatoribus duo ea. Ad doctus pertinacia ius, virtute fuisset id has, eum ut modo principes. Qui eu labore adversarium, oporteat delicata qui ut, an qui meliore principes. Id aliquid dolorum nam.</p>\r\n\r\n<p>Reque pericula philosophia ut mei, volumus eligendi mandamus has an. In nobis consulatu pri, has at timeam scaevola, has simul quaeque et. Te nec sale accumsan. Dolorem prodesset efficiendi sea ea.</p>\r\n\r\n<p>Et habeo modus debitis pri, vel quis fierent albucius ne. Ea animal meliore usu, nec etiam dolorum atomorum at, nam in audire mandamus omittantur. Cu ius dicam officiis molestiae, mea volumus officiis cotidieque no. Ut vel possim interpretaris, idque probatus antiopam has ad. Facilisi qualisque te sea, no dolorum mnesarchum usu.</p>\r\n\r\n<p>Eum tota graeci impetus an, eirmod invenire rationibus ne mel. Ignota habemus eum ex, vis omnesque delicata perpetua an. Sit id modo invidunt sapientem, ne eum vocibus dolores phaedrum. Case praesent appellantur eu per.</p>\r\n', '05-09-2017', 'news-5.jpg', 4, 24, 'Tollit cetero cu usu etiam evertitur', '', ''),
(6, 'Omnes ornatus qui et te aeterno', 'omnes-ornatus-qui-et-te-aeterno', '<p>Lorem ipsum dolor sit amet, qui case probo velit no, an postea scaevola partiendo mei. Id mea fuisset perpetua referrentur. Ut everti ceteros mei, alii discere eum no, duo id malis iuvaret. Ad sint everti accusam vel, ea viderer suscipiantur pri. Brute option minimum in cum, ignota iuvaret an pro.</p>\r\n\r\n<p>Solum atqui intellegebat mea an. Ne ius alterum aliquam. Ea nec populo aliquid mentitum, vis in meliore atomorum, sanctus consequat vituperatoribus duo ea. Ad doctus pertinacia ius, virtute fuisset id has, eum ut modo principes. Qui eu labore adversarium, oporteat delicata qui ut, an qui meliore principes. Id aliquid dolorum nam.</p>\r\n\r\n<p>Reque pericula philosophia ut mei, volumus eligendi mandamus has an. In nobis consulatu pri, has at timeam scaevola, has simul quaeque et. Te nec sale accumsan. Dolorem prodesset efficiendi sea ea.</p>\r\n\r\n<p>Et habeo modus debitis pri, vel quis fierent albucius ne. Ea animal meliore usu, nec etiam dolorum atomorum at, nam in audire mandamus omittantur. Cu ius dicam officiis molestiae, mea volumus officiis cotidieque no. Ut vel possim interpretaris, idque probatus antiopam has ad. Facilisi qualisque te sea, no dolorum mnesarchum usu.</p>\r\n\r\n<p>Eum tota graeci impetus an, eirmod invenire rationibus ne mel. Ignota habemus eum ex, vis omnesque delicata perpetua an. Sit id modo invidunt sapientem, ne eum vocibus dolores phaedrum. Case praesent appellantur eu per.</p>\r\n', '05-09-2017', 'news-6.jpg', 4, 2, 'Omnes ornatus qui et te aeterno', '', ''),
(7, 'Vix tale noluisse voluptua ad ne', 'vix-tale-noluisse-voluptua-ad-ne', '<p>Lorem ipsum dolor sit amet, qui case probo velit no, an postea scaevola partiendo mei. Id mea fuisset perpetua referrentur. Ut everti ceteros mei, alii discere eum no, duo id malis iuvaret. Ad sint everti accusam vel, ea viderer suscipiantur pri. Brute option minimum in cum, ignota iuvaret an pro.</p>\r\n\r\n<p>Solum atqui intellegebat mea an. Ne ius alterum aliquam. Ea nec populo aliquid mentitum, vis in meliore atomorum, sanctus consequat vituperatoribus duo ea. Ad doctus pertinacia ius, virtute fuisset id has, eum ut modo principes. Qui eu labore adversarium, oporteat delicata qui ut, an qui meliore principes. Id aliquid dolorum nam.</p>\r\n\r\n<p>Reque pericula philosophia ut mei, volumus eligendi mandamus has an. In nobis consulatu pri, has at timeam scaevola, has simul quaeque et. Te nec sale accumsan. Dolorem prodesset efficiendi sea ea.</p>\r\n\r\n<p>Et habeo modus debitis pri, vel quis fierent albucius ne. Ea animal meliore usu, nec etiam dolorum atomorum at, nam in audire mandamus omittantur. Cu ius dicam officiis molestiae, mea volumus officiis cotidieque no. Ut vel possim interpretaris, idque probatus antiopam has ad. Facilisi qualisque te sea, no dolorum mnesarchum usu.</p>\r\n\r\n<p>Eum tota graeci impetus an, eirmod invenire rationibus ne mel. Ignota habemus eum ex, vis omnesque delicata perpetua an. Sit id modo invidunt sapientem, ne eum vocibus dolores phaedrum. Case praesent appellantur eu per.</p>\r\n', '05-09-2017', 'news-7.jpg', 2, 0, 'Vix tale noluisse voluptua ad ne', '', ''),
(8, 'Liber utroque vim an ne his brute', 'liber-utroque-vim-an-ne-his-brute', '<p>Lorem ipsum dolor sit amet, qui case probo velit no, an postea scaevola partiendo mei. Id mea fuisset perpetua referrentur. Ut everti ceteros mei, alii discere eum no, duo id malis iuvaret. Ad sint everti accusam vel, ea viderer suscipiantur pri. Brute option minimum in cum, ignota iuvaret an pro.</p>\r\n\r\n<p>Solum atqui intellegebat mea an. Ne ius alterum aliquam. Ea nec populo aliquid mentitum, vis in meliore atomorum, sanctus consequat vituperatoribus duo ea. Ad doctus pertinacia ius, virtute fuisset id has, eum ut modo principes. Qui eu labore adversarium, oporteat delicata qui ut, an qui meliore principes. Id aliquid dolorum nam.</p>\r\n\r\n<p>Reque pericula philosophia ut mei, volumus eligendi mandamus has an. In nobis consulatu pri, has at timeam scaevola, has simul quaeque et. Te nec sale accumsan. Dolorem prodesset efficiendi sea ea.</p>\r\n\r\n<p>Et habeo modus debitis pri, vel quis fierent albucius ne. Ea animal meliore usu, nec etiam dolorum atomorum at, nam in audire mandamus omittantur. Cu ius dicam officiis molestiae, mea volumus officiis cotidieque no. Ut vel possim interpretaris, idque probatus antiopam has ad. Facilisi qualisque te sea, no dolorum mnesarchum usu.</p>\r\n\r\n<p>Eum tota graeci impetus an, eirmod invenire rationibus ne mel. Ignota habemus eum ex, vis omnesque delicata perpetua an. Sit id modo invidunt sapientem, ne eum vocibus dolores phaedrum. Case praesent appellantur eu per.</p>\r\n', '05-09-2017', 'news-8.jpg', 2, 12, 'Liber utroque vim an ne his brute', '', ''),
(9, 'Nostrum copiosae argumentum has', 'nostrum-copiosae-argumentum-has', '<p>Lorem ipsum dolor sit amet, qui case probo velit no, an postea scaevola partiendo mei. Id mea fuisset perpetua referrentur. Ut everti ceteros mei, alii discere eum no, duo id malis iuvaret. Ad sint everti accusam vel, ea viderer suscipiantur pri. Brute option minimum in cum, ignota iuvaret an pro.</p>\r\n\r\n<p>Solum atqui intellegebat mea an. Ne ius alterum aliquam. Ea nec populo aliquid mentitum, vis in meliore atomorum, sanctus consequat vituperatoribus duo ea. Ad doctus pertinacia ius, virtute fuisset id has, eum ut modo principes. Qui eu labore adversarium, oporteat delicata qui ut, an qui meliore principes. Id aliquid dolorum nam.</p>\r\n\r\n<p>Reque pericula philosophia ut mei, volumus eligendi mandamus has an. In nobis consulatu pri, has at timeam scaevola, has simul quaeque et. Te nec sale accumsan. Dolorem prodesset efficiendi sea ea.</p>\r\n\r\n<p>Et habeo modus debitis pri, vel quis fierent albucius ne. Ea animal meliore usu, nec etiam dolorum atomorum at, nam in audire mandamus omittantur. Cu ius dicam officiis molestiae, mea volumus officiis cotidieque no. Ut vel possim interpretaris, idque probatus antiopam has ad. Facilisi qualisque te sea, no dolorum mnesarchum usu.</p>\r\n\r\n<p>Eum tota graeci impetus an, eirmod invenire rationibus ne mel. Ignota habemus eum ex, vis omnesque delicata perpetua an. Sit id modo invidunt sapientem, ne eum vocibus dolores phaedrum. Case praesent appellantur eu per.</p>\r\n', '05-09-2017', 'news-9.jpg', 1, 12, 'Nostrum copiosae argumentum has', '', ''),
(10, 'An labores explicari qui eu', 'an-labores-explicari-qui-eu', '<p>Lorem ipsum dolor sit amet, qui case probo velit no, an postea scaevola partiendo mei. Id mea fuisset perpetua referrentur. Ut everti ceteros mei, alii discere eum no, duo id malis iuvaret. Ad sint everti accusam vel, ea viderer suscipiantur pri. Brute option minimum in cum, ignota iuvaret an pro.</p>\r\n\r\n<p>Solum atqui intellegebat mea an. Ne ius alterum aliquam. Ea nec populo aliquid mentitum, vis in meliore atomorum, sanctus consequat vituperatoribus duo ea. Ad doctus pertinacia ius, virtute fuisset id has, eum ut modo principes. Qui eu labore adversarium, oporteat delicata qui ut, an qui meliore principes. Id aliquid dolorum nam.</p>\r\n\r\n<p>Reque pericula philosophia ut mei, volumus eligendi mandamus has an. In nobis consulatu pri, has at timeam scaevola, has simul quaeque et. Te nec sale accumsan. Dolorem prodesset efficiendi sea ea.</p>\r\n\r\n<p>Et habeo modus debitis pri, vel quis fierent albucius ne. Ea animal meliore usu, nec etiam dolorum atomorum at, nam in audire mandamus omittantur. Cu ius dicam officiis molestiae, mea volumus officiis cotidieque no. Ut vel possim interpretaris, idque probatus antiopam has ad. Facilisi qualisque te sea, no dolorum mnesarchum usu.</p>\r\n\r\n<p>Eum tota graeci impetus an, eirmod invenire rationibus ne mel. Ignota habemus eum ex, vis omnesque delicata perpetua an. Sit id modo invidunt sapientem, ne eum vocibus dolores phaedrum. Case praesent appellantur eu per.</p>\r\n', '05-09-2017', 'news-10.jpg', 1, 4, 'An labores explicari qui eu', '', ''),
(11, 'Lorem ipsum dolor sit amet', 'lorem-ipsum-dolor-sit-amet', '<p>Lorem ipsum dolor sit amet, qui case probo velit no, an postea scaevola partiendo mei. Id mea fuisset perpetua referrentur. Ut everti ceteros mei, alii discere eum no, duo id malis iuvaret. Ad sint everti accusam vel, ea viderer suscipiantur pri. Brute option minimum in cum, ignota iuvaret an pro.</p>\r\n\r\n<p>Solum atqui intellegebat mea an. Ne ius alterum aliquam. Ea nec populo aliquid mentitum, vis in meliore atomorum, sanctus consequat vituperatoribus duo ea. Ad doctus pertinacia ius, virtute fuisset id has, eum ut modo principes. Qui eu labore adversarium, oporteat delicata qui ut, an qui meliore principes. Id aliquid dolorum nam.</p>\r\n\r\n<p>Reque pericula philosophia ut mei, volumus eligendi mandamus has an. In nobis consulatu pri, has at timeam scaevola, has simul quaeque et. Te nec sale accumsan. Dolorem prodesset efficiendi sea ea.</p>\r\n\r\n<p>Et habeo modus debitis pri, vel quis fierent albucius ne. Ea animal meliore usu, nec etiam dolorum atomorum at, nam in audire mandamus omittantur. Cu ius dicam officiis molestiae, mea volumus officiis cotidieque no. Ut vel possim interpretaris, idque probatus antiopam has ad. Facilisi qualisque te sea, no dolorum mnesarchum usu.</p>\r\n\r\n<p>Eum tota graeci impetus an, eirmod invenire rationibus ne mel. Ignota habemus eum ex, vis omnesque delicata perpetua an. Sit id modo invidunt sapientem, ne eum vocibus dolores phaedrum. Case praesent appellantur eu per.</p>\r\n', '05-09-2017', 'news-11.jpg', 1, 18, 'Lorem ipsum dolor sit amet', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_old_price` varchar(10) NOT NULL,
  `p_current_price` varchar(10) NOT NULL,
  `p_qty` int(10) NOT NULL,
  `p_featured_photo` varchar(255) NOT NULL,
  `p_description` text NOT NULL,
  `p_short_description` text NOT NULL,
  `p_feature` text NOT NULL,
  `p_condition` text NOT NULL,
  `p_return_policy` text NOT NULL,
  `p_total_view` int(11) NOT NULL,
  `p_is_featured` int(1) NOT NULL,
  `p_is_active` int(1) NOT NULL,
  `ecat_id` int(11) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`p_id`, `p_name`, `p_old_price`, `p_current_price`, `p_qty`, `p_featured_photo`, `p_description`, `p_short_description`, `p_feature`, `p_condition`, `p_return_policy`, `p_total_view`, `p_is_featured`, `p_is_active`, `ecat_id`, `seller_id`, `created_at`) VALUES
(109, 'headphone', '2200', '2100', 9, 'product-featured-109.png', '<p>rwrweqw</p>', '<p>wewqe</p>', '', '<p>asddad</p>', '<p>adsad</p>', 14, 0, 1, 62, 2, '2025-07-26 17:50:04'),
(110, 'NIKE Men Running Shoes', '10,000', '9,000', 10, 'product-featured-110.png', '<p style=\"margin: 0in 0in 12pt 12pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-family:\"Amazon Ember\",serif;\r\ncolor:#333333\">Designed for comfortable wear for sports and street\r\nstyle, NIKE is always fun to wear. Upgrade in style with a wide range from\r\nthe world’s leading and much-loved sports brand, NIKE.<o:p></o:p></span></p>', '', '<h3 style=\"margin-top: 0in; line-height: 12pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><br></h3>\r\n\r\n<p class=\"MsoNormal\" style=\"line-height: 10pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span class=\"a-color-base\"><b><span lang=\"EN-US\" style=\"font-size:9.0pt;mso-bidi-font-size:\r\n7.0pt;font-family:&quot;Amazon Ember&quot;,serif;color:#0F1111\">Material type</span></b></span><span lang=\"EN-US\" style=\"font-size:9.0pt;mso-bidi-font-size:7.0pt;font-family:&quot;Amazon Ember&quot;,serif;\r\ncolor:#0F1111\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class=\"a-color-base\">Mesh</span><o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"line-height: 10pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span class=\"a-color-base\"><b><span lang=\"EN-US\" style=\"font-size:9.0pt;mso-bidi-font-size:\r\n7.0pt;font-family:&quot;Amazon Ember&quot;,serif;color:#0F1111\">Closure type</span></b></span><span lang=\"EN-US\" style=\"font-size:9.0pt;mso-bidi-font-size:7.0pt;font-family:&quot;Amazon Ember&quot;,serif;\r\ncolor:#0F1111\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class=\"a-color-base\">Lace-Up</span><o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"line-height: 10pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span class=\"a-color-base\"><b><span lang=\"EN-US\" style=\"font-size:9.0pt;mso-bidi-font-size:\r\n7.0pt;font-family:&quot;Amazon Ember&quot;,serif;color:#0F1111\">Heel type</span></b></span><span lang=\"EN-US\" style=\"font-size:9.0pt;mso-bidi-font-size:7.0pt;font-family:&quot;Amazon Ember&quot;,serif;\r\ncolor:#0F1111\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class=\"a-color-base\">No Heel</span><o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"line-height: 10pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span class=\"a-color-base\"><b><span lang=\"EN-US\" style=\"font-size:9.0pt;mso-bidi-font-size:\r\n7.0pt;font-family:&quot;Amazon Ember&quot;,serif;color:#0F1111\">Water resistance level</span></b></span><span lang=\"EN-US\" style=\"font-size:9.0pt;mso-bidi-font-size:7.0pt;font-family:&quot;Amazon Ember&quot;,serif;\r\ncolor:#0F1111\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class=\"a-color-base\">Not Water Resistant</span><o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"line-height: 10pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span class=\"a-color-base\"><b><span lang=\"EN-US\" style=\"font-size:9.0pt;mso-bidi-font-size:\r\n7.0pt;font-family:&quot;Amazon Ember&quot;,serif;color:#0F1111\">Sole material</span></b></span><span lang=\"EN-US\" style=\"font-size:9.0pt;mso-bidi-font-size:7.0pt;font-family:&quot;Amazon Ember&quot;,serif;\r\ncolor:#0F1111\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class=\"a-color-base\">Rubber</span><o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"line-height: 10pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span class=\"a-color-base\"><b><span lang=\"EN-US\" style=\"font-size:9.0pt;mso-bidi-font-size:\r\n7.0pt;font-family:&quot;Amazon Ember&quot;,serif;color:#0F1111\">Style</span></b></span><span lang=\"EN-US\" style=\"font-size:9.0pt;mso-bidi-font-size:7.0pt;font-family:&quot;Amazon Ember&quot;,serif;\r\ncolor:#0F1111\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"a-color-base\">Running Shoes</span><o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"line-height: 10pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span class=\"a-color-base\"><b><span lang=\"EN-US\" style=\"font-size:9.0pt;mso-bidi-font-size:\r\n7.0pt;font-family:&quot;Amazon Ember&quot;,serif;color:#0F1111\">Country of Origin</span></b></span><span lang=\"EN-US\" style=\"font-size:9.0pt;mso-bidi-font-size:7.0pt;font-family:&quot;Amazon Ember&quot;,serif;\r\ncolor:#0F1111\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n<span class=\"a-color-base\">Vietnam</span><o:p></o:p></span></p>', '<p class=\"MsoNormal\" style=\"line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:9.0pt;mso-bidi-font-size:7.0pt;font-family:&quot;Amazon Ember&quot;,serif;\r\nmso-fareast-font-family:&quot;Times New Roman&quot;;mso-bidi-font-family:&quot;Times New Roman&quot;;\r\ncolor:#0F1111;mso-font-kerning:0pt\">Keep the item in its original condition and\r\npackaging along with MRP tag and accessories for a successful pick-up.<o:p></o:p></span></p>', '<p class=\"MsoNormal\" style=\"line-height: 10pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size: 7pt; font-family: &quot;Amazon Ember&quot;, serif; color: rgb(15, 17, 17); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">This item is eligible for return within 10 days of delivery.\r\nYou can also exchange this item for a different size/color (based on item\r\navailability) or return for a full refund.</span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:&quot;Amazon Ember&quot;,serif;color:#0F1111\"><br>\r\n<br>\r\n<span style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Please keep the item in its original condition,\r\nwith brand outer box, MRP tags attached, warranty cards, and original accessories\r\nin manufacturer packaging for a successful refund/replacement.</span></span><span lang=\"EN-US\" style=\"font-size:16.0pt;font-family:&quot;Amazon Ember&quot;,serif;color:#0F1111\"><o:p></o:p></span></p>', 3, 1, 1, 5, 7, '2025-07-27 19:13:09'),
(111, 'Ray-Ban Junior Unisex Round Sunglasses - 0RJ9547S', '4890', '4399', 9, 'product-featured-111.png', '<p style=\"margin: 0in 0in 12pt 12pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-family:\"Amazon Ember\",serif;\r\ncolor:#333333\">Ray-Ban is an American-founded Italian brand of luxury\r\nsunglasses and eyeglasses created in 1936 by the American company Bausch &\r\nLomb. The brand is known for its Wayfarer and Aviator lines of sunglasses.<o:p></o:p></span></p>', '<p><span lang=\"EN-US\" style=\"font-size:11.0pt;line-height:\r\n115%;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:Calibri;\r\nmso-fareast-theme-font:minor-latin;mso-bidi-font-family:Shruti;mso-bidi-theme-font:\r\nminor-bidi;color:#333333;mso-ansi-language:EN-US;mso-fareast-language:EN-US;\r\nmso-bidi-language:GU\">Ray-Ban is an American-founded Italian brand of luxury\r\nsunglasses and eyeglasses created in 1936 by the American company Bausch &\r\nLomb.</span></p>', '<p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">Heritage\r\nof Excellence: Founded in 1937, Ray-Ban revolutionized eyewear with iconic\r\nstyles like the Aviator, originally designed for U.S. Air Force pilots.</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">Durable\r\nBuild: Lightweight yet sturdy frames ensure long-lasting wear, combining\r\ncomfort and durability for everyday use.</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">Lens\r\nVariety: Available in polarized, gradient, and mirrored lenses, each offering\r\nunique benefits like reduced glare, enhanced contrast, and stylish looks, all\r\nwhile providing superior UV protection. Chose what you prefer</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">Lens\r\nWidth : 44 mm, Bridge Width : 19 mm, Temple Length : 130 mm</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">They say\r\nthe best things come in small packages, and these shades are no exception. The\r\nâ€œmini-meâ€ version of the Round classic brings premium metal construction and\r\nthe iconic Ray-Ban look to kids everywhere. Pick up a pair with classic dark\r\ngreen lenses or choose from an array of gradient options.</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p>', '<p class=\"MsoNormal\" style=\"line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Keep the item in its original condition and packaging\r\nalong with MRP tag and accessories for a successful pick-up.<o:p></o:p></span></p>', '<p class=\"MsoNormal\" style=\"line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Keep the item in its original condition and packaging\r\nalong with MRP tag and accessories for a successful pick-up.<o:p></o:p></span></p>', 4, 0, 1, 2, 6, '2025-07-27 19:37:14');
INSERT INTO `tbl_product` (`p_id`, `p_name`, `p_old_price`, `p_current_price`, `p_qty`, `p_featured_photo`, `p_description`, `p_short_description`, `p_feature`, `p_condition`, `p_return_policy`, `p_total_view`, `p_is_featured`, `p_is_active`, `ecat_id`, `seller_id`, `created_at`) VALUES
(112, 'Sylvi Timegrapher Luxury Business Casual Party-Wear Leather Strap Chronograph Date Display Watch for Men | Working Chronograph Watch for Men - 556 Blue RG Leather', '2499', '1428', 4, 'product-featured-112.png', '<p class=\"MsoNormal\" style=\"margin: 0in 0in 2.75pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;mso-fareast-font-family:\r\nSymbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">       </span></span><!--[endif]--><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\">Batteries </span></span><span dir=\"RTL\"></span><span dir=\"RTL\"></span><span class=\"a-text-bold\"><span lang=\"AR-SA\" dir=\"RTL\" style=\"font-size:7.0pt;font-family:\r\n\"Times New Roman\",serif;color:#0F1111;mso-bidi-language:AR-SA\"><span dir=\"RTL\"></span><span dir=\"RTL\"></span>?</span></span><span dir=\"LTR\"></span><span dir=\"LTR\"></span><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"><span dir=\"LTR\"></span><span dir=\"LTR\"></span> : </span></span><span class=\"a-text-bold\"><span lang=\"GU\" style=\"font-size:7.0pt;font-family:\"Times New Roman\",serif;\r\ncolor:#0F1111\">?</span></span><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"> </span></span><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\">1 Lithium Ion batteries required. (included)</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 2.75pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;mso-fareast-font-family:\r\nSymbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">       </span></span><!--[endif]--><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\">Product Dimensions </span></span><span dir=\"RTL\"></span><span dir=\"RTL\"></span><span class=\"a-text-bold\"><span lang=\"AR-SA\" dir=\"RTL\" style=\"font-size:7.0pt;font-family:\"Times New Roman\",serif;color:#0F1111;\r\nmso-bidi-language:AR-SA\"><span dir=\"RTL\"></span><span dir=\"RTL\"></span>?</span></span><span dir=\"LTR\"></span><span dir=\"LTR\"></span><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><span dir=\"LTR\"></span><span dir=\"LTR\"></span> : </span></span><span class=\"a-text-bold\"><span lang=\"GU\" style=\"font-size:7.0pt;font-family:\"Times New Roman\",serif;color:#0F1111\">?</span></span><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"> </span></span><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">12 x 12\r\nx 12 cm; 140 g</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\r\n\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 2.75pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;mso-fareast-font-family:\r\nSymbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">       </span></span><!--[endif]--><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\">Date First Available </span></span><span dir=\"RTL\"></span><span dir=\"RTL\"></span><span class=\"a-text-bold\"><span lang=\"AR-SA\" dir=\"RTL\" style=\"font-size:7.0pt;font-family:\"Times New Roman\",serif;color:#0F1111;\r\nmso-bidi-language:AR-SA\"><span dir=\"RTL\"></span><span dir=\"RTL\"></span>?</span></span><span dir=\"LTR\"></span><span dir=\"LTR\"></span><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><span dir=\"LTR\"></span><span dir=\"LTR\"></span> : </span></span><span class=\"a-text-bold\"><span lang=\"GU\" style=\"font-size:7.0pt;font-family:\"Times New Roman\",serif;color:#0F1111\">?</span></span><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"> </span></span><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">6 May\r\n2024</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 2.75pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;mso-fareast-font-family:\r\nSymbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">       </span></span><!--[endif]--><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\">Manufacturer </span></span><span dir=\"RTL\"></span><span dir=\"RTL\"></span><span class=\"a-text-bold\"><span lang=\"AR-SA\" dir=\"RTL\" style=\"font-size:7.0pt;font-family:\r\n\"Times New Roman\",serif;color:#0F1111;mso-bidi-language:AR-SA\"><span dir=\"RTL\"></span><span dir=\"RTL\"></span>?</span></span><span dir=\"LTR\"></span><span dir=\"LTR\"></span><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"><span dir=\"LTR\"></span><span dir=\"LTR\"></span> : </span></span><span class=\"a-text-bold\"><span lang=\"GU\" style=\"font-size:7.0pt;font-family:\"Times New Roman\",serif;\r\ncolor:#0F1111\">?</span></span><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"> </span></span><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\">Sylvi</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;\r\nfont-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 2.75pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;mso-fareast-font-family:\r\nSymbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">       </span></span><!--[endif]--><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\">ASIN </span></span><span dir=\"RTL\"></span><span dir=\"RTL\"></span><span class=\"a-text-bold\"><span lang=\"AR-SA\" dir=\"RTL\" style=\"font-size:7.0pt;font-family:\r\n\"Times New Roman\",serif;color:#0F1111;mso-bidi-language:AR-SA\"><span dir=\"RTL\"></span><span dir=\"RTL\"></span>?</span></span><span dir=\"LTR\"></span><span dir=\"LTR\"></span><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"><span dir=\"LTR\"></span><span dir=\"LTR\"></span> : </span></span><span class=\"a-text-bold\"><span lang=\"GU\" style=\"font-size:7.0pt;font-family:\"Times New Roman\",serif;\r\ncolor:#0F1111\">?</span></span><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"> </span></span><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\">B08XBYW54Y</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;\r\nfont-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 2.75pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;mso-fareast-font-family:\r\nSymbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">       </span></span><!--[endif]--><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\">Item model number </span></span><span dir=\"RTL\"></span><span dir=\"RTL\"></span><span class=\"a-text-bold\"><span lang=\"AR-SA\" dir=\"RTL\" style=\"font-size:7.0pt;font-family:\"Times New Roman\",serif;color:#0F1111;\r\nmso-bidi-language:AR-SA\"><span dir=\"RTL\"></span><span dir=\"RTL\"></span>?</span></span><span dir=\"LTR\"></span><span dir=\"LTR\"></span><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><span dir=\"LTR\"></span><span dir=\"LTR\"></span> : </span></span><span class=\"a-text-bold\"><span lang=\"GU\" style=\"font-size:7.0pt;font-family:\"Times New Roman\",serif;color:#0F1111\">?</span></span><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"> </span></span><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">556</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 2.75pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;mso-fareast-font-family:\r\nSymbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">       </span></span><!--[endif]--><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\">Country of Origin </span></span><span dir=\"RTL\"></span><span dir=\"RTL\"></span><span class=\"a-text-bold\"><span lang=\"AR-SA\" dir=\"RTL\" style=\"font-size:7.0pt;font-family:\"Times New Roman\",serif;color:#0F1111;\r\nmso-bidi-language:AR-SA\"><span dir=\"RTL\"></span><span dir=\"RTL\"></span>?</span></span><span dir=\"LTR\"></span><span dir=\"LTR\"></span><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><span dir=\"LTR\"></span><span dir=\"LTR\"></span> : </span></span><span class=\"a-text-bold\"><span lang=\"GU\" style=\"font-size:7.0pt;font-family:\"Times New Roman\",serif;color:#0F1111\">?</span></span><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"> </span></span><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">India</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 2.75pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;mso-fareast-font-family:\r\nSymbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">       </span></span><!--[endif]--><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\">Department </span></span><span dir=\"RTL\"></span><span dir=\"RTL\"></span><span class=\"a-text-bold\"><span lang=\"AR-SA\" dir=\"RTL\" style=\"font-size:7.0pt;font-family:\r\n\"Times New Roman\",serif;color:#0F1111;mso-bidi-language:AR-SA\"><span dir=\"RTL\"></span><span dir=\"RTL\"></span>?</span></span><span dir=\"LTR\"></span><span dir=\"LTR\"></span><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"><span dir=\"LTR\"></span><span dir=\"LTR\"></span> : </span></span><span class=\"a-text-bold\"><span lang=\"GU\" style=\"font-size:7.0pt;font-family:\"Times New Roman\",serif;\r\ncolor:#0F1111\">?</span></span><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"> </span></span><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\">Men</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;\r\nfont-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 2.75pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;mso-fareast-font-family:\r\nSymbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">       </span></span><!--[endif]--><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\">Manufacturer </span></span><span dir=\"RTL\"></span><span dir=\"RTL\"></span><span class=\"a-text-bold\"><span lang=\"AR-SA\" dir=\"RTL\" style=\"font-size:7.0pt;font-family:\r\n\"Times New Roman\",serif;color:#0F1111;mso-bidi-language:AR-SA\"><span dir=\"RTL\"></span><span dir=\"RTL\"></span>?</span></span><span dir=\"LTR\"></span><span dir=\"LTR\"></span><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"><span dir=\"LTR\"></span><span dir=\"LTR\"></span> : </span></span><span class=\"a-text-bold\"><span lang=\"GU\" style=\"font-size:7.0pt;font-family:\"Times New Roman\",serif;\r\ncolor:#0F1111\">?</span></span><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"> </span></span><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\">Sylvi</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;\r\nfont-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 2.75pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;mso-fareast-font-family:\r\nSymbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">       </span></span><!--[endif]--><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\">Item Weight </span></span><span dir=\"RTL\"></span><span dir=\"RTL\"></span><span class=\"a-text-bold\"><span lang=\"AR-SA\" dir=\"RTL\" style=\"font-size:7.0pt;font-family:\r\n\"Times New Roman\",serif;color:#0F1111;mso-bidi-language:AR-SA\"><span dir=\"RTL\"></span><span dir=\"RTL\"></span>?</span></span><span dir=\"LTR\"></span><span dir=\"LTR\"></span><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"><span dir=\"LTR\"></span><span dir=\"LTR\"></span> : </span></span><span class=\"a-text-bold\"><span lang=\"GU\" style=\"font-size:7.0pt;font-family:\"Times New Roman\",serif;\r\ncolor:#0F1111\">?</span></span><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"> </span></span><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\">140 g</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;\r\nfont-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 2.75pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;mso-fareast-font-family:\r\nSymbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">       </span></span><!--[endif]--><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\">Item Dimensions LxWxH </span></span><span dir=\"RTL\"></span><span dir=\"RTL\"></span><span class=\"a-text-bold\"><span lang=\"AR-SA\" dir=\"RTL\" style=\"font-size:7.0pt;font-family:\"Times New Roman\",serif;color:#0F1111;\r\nmso-bidi-language:AR-SA\"><span dir=\"RTL\"></span><span dir=\"RTL\"></span>?</span></span><span dir=\"LTR\"></span><span dir=\"LTR\"></span><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><span dir=\"LTR\"></span><span dir=\"LTR\"></span> : </span></span><span class=\"a-text-bold\"><span lang=\"GU\" style=\"font-size:7.0pt;font-family:\"Times New Roman\",serif;color:#0F1111\">?</span></span><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"> </span></span><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">12 x 12\r\nx 12 Centimeters</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;\r\nfont-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\" style=\"margin: 0in 0in 2.75pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:\r\n7.0pt;font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span></span><!--[endif]--><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">Net\r\nQuantity </span></span><span dir=\"RTL\"></span><span dir=\"RTL\"></span><span class=\"a-text-bold\"><span lang=\"AR-SA\" dir=\"RTL\" style=\"font-size:7.0pt;font-family:\r\n\"Times New Roman\",serif;color:#0F1111;mso-bidi-language:AR-SA\"><span dir=\"RTL\"></span><span dir=\"RTL\"></span>?</span></span><span dir=\"LTR\"></span><span dir=\"LTR\"></span><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"><span dir=\"LTR\"></span><span dir=\"LTR\"></span> : </span></span><span class=\"a-text-bold\"><span lang=\"GU\" style=\"font-size:7.0pt;font-family:\"Times New Roman\",serif;\r\ncolor:#0F1111\">?</span></span><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"> </span></span><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\">1.00 Count<o:p></o:p></span></span></p>', '<p><span class=\"a-size-large\"><b><span lang=\"EN-US\" style=\"font-size:11.0pt;line-height:115%;font-family:\"Amazon Ember\",serif;\r\nmso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-bidi-font-family:\r\nShruti;mso-bidi-theme-font:minor-bidi;color:#0F1111;mso-ansi-language:EN-US;\r\nmso-fareast-language:EN-US;mso-bidi-language:GU\">Sylvi Timegrapher Luxury\r\nBusiness Casual Party-Wear Leather Strap Chronograph Date Display Watch for Men</span></b></span></p>', '<p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111;\r\nmso-font-kerning:0pt\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:7.0pt;\r\nmso-bidi-font-size:11.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Chronograph</span><span lang=\"EN-US\" style=\"font-size:7.0pt;\r\nfont-family:\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";\r\nmso-bidi-font-family:\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111;\r\nmso-font-kerning:0pt\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:7.0pt;\r\nmso-bidi-font-size:11.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Water Resistant</span><span lang=\"EN-US\" style=\"font-size:\r\n7.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";\r\nmso-bidi-font-family:\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\"><o:p></o:p></span></p><p>\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111;\r\nmso-font-kerning:0pt\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:7.0pt;\r\nmso-bidi-font-size:11.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Bezel Markings</span><span lang=\"EN-US\" style=\"font-size:\r\n7.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";\r\nmso-bidi-font-family:\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\"><o:p></o:p></span></p>', '<p class=\"MsoNormal\" style=\"line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Keep the item in its original condition and packaging\r\nalong with MRP tag and accessories for a successful pick-up.<o:p></o:p></span></p>', '<p class=\"MsoNormal\" style=\"line-height: 10pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size: 7pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">This item is eligible for return within 10 days of delivery.\r\nYou can also exchange this item for a different size/color (based on item\r\navailability) or return for a full refund.</span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><br>\r\n<br>\r\n<span style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Please keep the item in its original condition,\r\nwith brand outer box, MRP tags attached, warranty cards, and original accessories\r\nin manufacturer packaging for a successful refund/replacement.</span></span><span lang=\"EN-US\" style=\"font-size:16.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p>', 1, 0, 1, 3, 6, '2025-07-27 19:39:41'),
(113, 'U.S. POLO ASSN. Men\'s Solid Linen Tailored Fit Button Down Half Sleeve Casual Shirt', '3499', '2499', 5, 'product-featured-113.png', '<p style=\"margin: 0in 0in 12pt 12pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-family:\"Amazon Ember\",serif;\r\ncolor:#333333\">This linen shirt is made of the finest quality and remarkable\r\ncraftsmanship, featuring a spread collar and short sleeves.<o:p></o:p></span></p>', '', '', '<p class=\"MsoNormal\" style=\"line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\" amazon=\"\" ember\",serif;mso-fareast-font-family:=\"\" \"times=\"\" new=\"\" roman\";mso-bidi-font-family:\"times=\"\" roman\";color:#0f1111;=\"\" mso-font-kerning:0pt\"=\"\">Keep the item in its original condition and packaging\r\nalong with MRP tag and accessories for a successful pick-up.<o:p></o:p></span></p>', '<p class=\"MsoNormal\" style=\"line-height: 10pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size: 7pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">This item is eligible for return within 10 days of delivery.\r\nYou can also exchange this item for a different size/color (based on item\r\navailability) or return for a full refund.</span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><br>\r\n<br>\r\n<span style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Please keep the item in its original condition,\r\nwith brand outer box, MRP tags attached, warranty cards, and original\r\naccessories in manufacturer packaging for a successful refund/replacement.</span></span><span lang=\"EN-US\" style=\"font-size:16.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p>', 0, 1, 1, 20, 6, '2025-07-27 19:41:45'),
(114, 'Leather Retail Men\'s Black Solid Jacket', '3999', '2999', 4, 'product-featured-114.png', '<h2 style=\"margin-top: 0in; line-height: 16pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size: 10pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Welcome to <span class=\"a-text-bold\">Leather Retail </span>your\r\npremier destination for high-quality leather jackets for women, men, and kids\r\nWith a passion for fashion and a commitment to craftsmanship, we specialize in\r\nproviding stylish and durable leather outerwear that caters to every member of\r\nthe family</span><span lang=\"EN-US\" style=\"font-size: 7pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17);\"><o:p></o:p></span></h2>', '<h2 style=\"margin-top: 0in; line-height: 16pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size: 10pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Welcome to <span class=\"a-text-bold\">Leather Retail </span>your\r\npremier destination for high-quality leather jackets for women, men, and kids\r\nWith a passion for fashion and a commitment to craftsmanship, we specialize in\r\nproviding stylish and durable leather outerwear that caters to every member of\r\nthe family</span><span lang=\"EN-US\" style=\"font-size: 7pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17);\"><o:p></o:p></span></h2>', '', '<p>    <span style=\"color: rgb(15, 17, 17); font-family: \"Amazon Ember\", serif; font-size: 7pt;\">Keep the item in its original condition and packaging\r\nalong with MRP tag and accessories for a successful pick-up.</span></p><p class=\"MsoNormal\" style=\"line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\"><o:p></o:p></span></p>', '<p class=\"MsoNormal\" style=\"line-height: 10pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size: 7pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">This item is eligible for return within 10 days of delivery.\r\nYou can also exchange this item for a different size/color (based on item\r\navailability) or return for a full refund.</span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><br>\r\n<br>\r\n<span style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Please keep the item in its original condition,\r\nwith brand outer box, MRP tags attached, warranty cards, and original\r\naccessories in manufacturer packaging for a successful refund/replacement.</span></span><span lang=\"EN-US\" style=\"font-size:16.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p>', 0, 0, 1, 22, 6, '2025-07-27 19:43:53'),
(115, 'Kvetoo V Neck Sleeveless Winter Wool Sweater for Men', '4999', '3999', 1, 'product-featured-115.png', '<p style=\"margin: 0in 0in 12pt 12pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-family:\"Amazon Ember\",serif;\r\ncolor:#333333\">Perfect for your everyday use, you could layer them over a\r\nstylish T-Shirt, Polo or Casual shirt to complete the look.<o:p></o:p></span></p>', '', '', '<p class=\"MsoNormal\" style=\"line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Keep the item in its original condition and packaging\r\nalong with MRP tag and accessories for a successful pick-up.<o:p></o:p></span></p>', '<h1 style=\"margin-top: 0in; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size: 7pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">This\r\nitem is eligible for return within 10 days of delivery. You can also exchange\r\nthis item for a different size/color (based on item availability) or return for\r\na full refund.</span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"><br>\r\n<br>\r\n<span style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Please keep the item in its original condition,\r\nwith brand outer box, MRP tags attached, warranty cards, and original\r\naccessories in manufacturer packaging for a successful refund/replacement</span></span><span lang=\"EN-US\" style=\"font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17);\"><o:p></o:p></span></h1>', 11, 1, 1, 20, 6, '2025-07-27 19:46:42');
INSERT INTO `tbl_product` (`p_id`, `p_name`, `p_old_price`, `p_current_price`, `p_qty`, `p_featured_photo`, `p_description`, `p_short_description`, `p_feature`, `p_condition`, `p_return_policy`, `p_total_view`, `p_is_featured`, `p_is_active`, `ecat_id`, `seller_id`, `created_at`) VALUES
(116, 'Sheetal A ssociates Crepe Women\'s Mix Floral Printed Grown with Regular Sleeves Full Lenth and Square Neck | Beach Tipe Dress', '6900', '4900', 4, 'product-featured-116.png', '<p><span lang=\"EN-US\" style=\"font-size:10.0pt;line-height:\r\n115%;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:Calibri;\r\nmso-fareast-theme-font:minor-latin;mso-bidi-font-family:Shruti;mso-bidi-theme-font:\r\nminor-bidi;color:#0F1111;mso-ansi-language:EN-US;mso-fareast-language:EN-US;\r\nmso-bidi-language:GU\">The <span class=\"a-text-bold\">long length</span> of\r\nthe Women\'s Maxi Floral Print Crepe Regular Sleeves Casual Dress adds an\r\nelegant and flowing silhouette, offering a flattering and graceful look that\r\nreaches the ankles or even the floor, depending on height. This design is\r\nperfect for creating a relaxed yet refined style, making it ideal for casual\r\noutings, weekend events, or even semi-formal occasions. The long length allows\r\nfor easy movement and pairs beautifully with sandals, heels, or flats,\r\nproviding a versatile option for a variety of occasions</span></p>', '<p><span lang=\"EN-US\" style=\"font-size:10.0pt;line-height:\r\n115%;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:Calibri;\r\nmso-fareast-theme-font:minor-latin;mso-bidi-font-family:Shruti;mso-bidi-theme-font:\r\nminor-bidi;color:#0F1111;mso-ansi-language:EN-US;mso-fareast-language:EN-US;\r\nmso-bidi-language:GU\">The <span class=\"a-text-bold\">long length</span> of\r\nthe Women\'s Maxi Floral Print Crepe Regular Sleeves Casual Dress adds an\r\nelegant and flowing silhouette, offering a flattering and graceful look that\r\nreaches the ankles or even the floor, depending on height. This design is\r\nperfect for creating a relaxed yet refined style, making it ideal for casual\r\noutings, weekend events, or even semi-formal occasions. The long length allows\r\nfor easy movement and pairs beautifully with sandals, heels, or flats,\r\nproviding a versatile option for a variety of occasions</span></p>', '<p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111;\r\nmso-font-kerning:0pt\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:7.0pt;\r\nmso-bidi-font-size:11.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Soft Crepe Fabric: Lightweight and breathable,\r\nperfect for all-day wear.</span><span lang=\"EN-US\" style=\"font-size:7.0pt;\r\nfont-family:\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";\r\nmso-bidi-font-family:\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111;\r\nmso-font-kerning:0pt\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:7.0pt;\r\nmso-bidi-font-size:11.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Floral Print Design: Fresh, vibrant print adds a\r\nfeminine touch.</span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\nmso-fareast-font-family:\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";\r\ncolor:#0F1111;mso-font-kerning:0pt\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111;\r\nmso-font-kerning:0pt\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:7.0pt;\r\nmso-bidi-font-size:11.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Maxi Length: Flowy, flattering silhouette that suits\r\na variety of body types.</span><span lang=\"EN-US\" style=\"font-size:7.0pt;\r\nfont-family:\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";\r\nmso-bidi-font-family:\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111;\r\nmso-font-kerning:0pt\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:7.0pt;\r\nmso-bidi-font-size:11.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Regular Sleeves: Comfortable, casual fit ideal for\r\ndaily wear.</span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\nmso-fareast-font-family:\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";\r\ncolor:#0F1111;mso-font-kerning:0pt\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111;\r\nmso-font-kerning:0pt\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:7.0pt;\r\nmso-bidi-font-size:11.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Versatile Style: Perfect for casual outings, weekend\r\ntrips, or relaxed events.</span><span lang=\"EN-US\" style=\"font-size:7.0pt;\r\nfont-family:\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";\r\nmso-bidi-font-family:\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\"><o:p></o:p></span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111;\r\nmso-font-kerning:0pt\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:7.0pt;\r\nmso-bidi-font-size:11.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Easy Care: Machine washable for convenience and easy\r\nmaintenance.</span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\nmso-fareast-font-family:\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";\r\ncolor:#0F1111;mso-font-kerning:0pt\"><o:p></o:p></span></p>', '<p class=\"MsoNormal\" style=\"line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Keep the item in its original condition and packaging\r\nalong with MRP tag and accessories for a successful pick-up.<o:p></o:p></span></p>', '<h1 style=\"margin-top: 0in; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size: 7pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">This\r\nitem is eligible for return within 10 days of delivery. You can also exchange\r\nthis item for a different size/color (based on item availability) or return for\r\na full refund.</span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"><br>\r\n<br>\r\n<span style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Please keep the item in its original condition,\r\nwith brand outer box, MRP tags attached, warranty cards, and original\r\naccessories in manufacturer packaging for a successful refund/replacement</span></span><span lang=\"EN-US\" style=\"font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17);\"><o:p></o:p></span></h1>', 1, 0, 1, 32, 7, '2025-07-27 19:52:02'),
(117, 'Ekasya Women\'s Organza Embroidery Work Saree, Elegant Party & Wedding Wear Saree for Women ', '3455', '2455', 2, 'product-featured-117.png', '<h1 style=\"margin-top: 0in; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span class=\"a-size-large\"><span lang=\"EN-US\" style=\"font-size: 11pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17);\">Premium Quality, Intricate Embroidery, Perfect for Special\r\nOccasions, Stylish & Comfortable</span></span><span lang=\"EN-US\" style=\"font-size: 11pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17);\"><o:p></o:p></span></h1>', '<h1 style=\"margin-top: 0in; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span class=\"a-size-large\"><span lang=\"EN-US\" style=\"font-size: 11pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17);\">Premium Quality, Intricate Embroidery, Perfect for Special\r\nOccasions, Stylish & Comfortable</span></span><span lang=\"EN-US\" style=\"font-size: 11pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17);\"><o:p></o:p></span></h1>', '<p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Cambria Math\",serif;mso-bidi-font-family:\r\n\"Cambria Math\";color:#0F1111\">?????</span></span><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"> </span></span><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Cambria Math\",serif;mso-bidi-font-family:\r\n\"Cambria Math\";color:#0F1111\">??????</span></span><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"> : Saree colour: Wine| Material : Organza| Length: 5.5 mtr</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Cambria Math\",serif;mso-bidi-font-family:\r\n\"Cambria Math\";color:#0F1111\">??????</span></span><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"> </span></span><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Cambria Math\",serif;mso-bidi-font-family:\r\n\"Cambria Math\";color:#0F1111\">??????</span></span><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\">: Blouse colour: Wine| Material: Organza| Length: 0.8m</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">Wash\r\nCare: Dry Clean Only</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;\r\nfont-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Cambria Math\",serif;mso-bidi-font-family:\r\n\"Cambria Math\";color:#0F1111\">????????</span></span><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"> : Dress to impress, or to look your best- the saree can be worn\r\nin multiple occasions such as house warming occasions. You can pair these\r\nsarees with sandals, high heels or flats and any vent with confidence and\r\nsmile.</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"><o:p></o:p></span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Cambria Math\",serif;mso-bidi-font-family:\r\n\"Cambria Math\";color:#0F1111\">?????????</span></span><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"> : Product colour may slightly vary due to photographic lighting\r\nsources on monitor settings or device settings and lighting used in mode.</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p>', '<p class=\"MsoNormal\" style=\"line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Keep the item in its original condition and packaging\r\nalong with MRP tag and accessories for a successful pick-up.<o:p></o:p></span></p>', '<h1 style=\"margin-top: 0in; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size: 7pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">This\r\nitem is eligible for return within 10 days of delivery. You can also exchange\r\nthis item for a different size/color (based on item availability) or return for\r\na full refund.</span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"><br>\r\n<br>\r\n<span style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Please keep the item in its original condition,\r\nwith brand outer box, MRP tags attached, warranty cards, and original\r\naccessories in manufacturer packaging for a successful refund/replacement</span></span><span lang=\"EN-US\" style=\"font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17);\"><o:p></o:p></span></h1>', 0, 0, 1, 32, 7, '2025-07-27 19:54:03'),
(118, 'BAGMODE Women\'s Classic Top Handle Handbag, White Leather with Gold Hardware, Crossbody Strap', '10000', '8000', 5, 'product-featured-118.png', '<p style=\"margin: 0in 0in 12pt 12pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:10.0pt;font-family:\r\n\"Amazon Ember\",serif;color:#333333\">Elevate your style with this sophisticated\r\nwhite leather handbag that seamlessly blends classic elegance with modern\r\nfunctionality. The structured design features gleaming gold-tone hardware,\r\nincluding a distinctive double-G emblem that adds a luxurious touch to the\r\nclean, minimalist silhouette. The bag\'s versatile nature shines through with\r\nits dual carrying options - a sturdy top handle for a polished look and an\r\nadjustable crossbody strap for hands-free convenience. Crafted from premium\r\nleather in pristine white, this handbag offers both style and practicality for\r\nthe discerning fashion enthusiast. The elegant proportions and timeless design\r\nmake it a perfect companion for both daytime engagements and evening occasions.\r\nThe refined gold-tone accents, including the architectural handle supports and\r\nhardware details, create a striking contrast against the white leather,\r\nensuring this bag makes a sophisticated statement wherever you go</span><span lang=\"EN-US\" style=\"font-family:\"Amazon Ember\",serif;color:#333333\">.<o:p></o:p></span></p>', '', '<p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">DESIGN\r\nFEATURES: Elegant white leather handbag with luxurious gold-tone hardware\r\naccents and distinctive double-G logo embellishment</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">VERSATILE\r\nCARRY: Includes both a sturdy top handle and an adjustable shoulder strap for\r\nmultiple carrying options</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;\r\nfont-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">PREMIUM\r\nMATERIALS: Crafted from high-quality white leather with durable metal hardware\r\nin sophisticated gold finish</span></span><span lang=\"EN-US\" style=\"font-size:\r\n7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">PRACTICAL\r\nSIZE: Perfect dimensions for daily essentials whilst maintaining a sleek,\r\nstructured silhouette</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;\r\nfont-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:\r\n7.0pt;font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">STYLE\r\nELEMENTS: Classic trapezoid shape with minimalist design, featuring metallic\r\narch handle and decorative logo placement</span></span></p>', '<p class=\"MsoNormal\" style=\"line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Keep the item in its original condition and packaging\r\nalong with MRP tag and accessories for a successful pick-up.<o:p></o:p></span></p>', '<h1 style=\"margin-top: 0in; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size: 7pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">This\r\nitem is eligible for return within 10 days of delivery. You can also exchange\r\nthis item for a different size/color (based on item availability) or return for\r\na full refund.</span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"><br>\r\n<br>\r\n<span style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Please keep the item in its original condition,\r\nwith brand outer box, MRP tags attached, warranty cards, and original\r\naccessories in manufacturer packaging for a successful refund/replacement</span></span><span lang=\"EN-US\" style=\"font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17);\"><o:p></o:p></span></h1>', 4, 1, 1, 60, 7, '2025-07-27 19:55:56'),
(119, 'Creattoes Premium Lace-Up Boots for Women & Girls – Fashionable, All-Day Comfort, Perfect for Casual & Outdoor Wear | CR20', '45000', '42000', 7, 'product-featured-119.png', '<p style=\"margin: 0in 0in 12pt 12pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:10.0pt;font-family:\r\n\"Amazon Ember\",serif;color:#333333\">Step up your fashion game with the\r\nCREATTOES Women & Girl Boots </span><span lang=\"EN-US\" style=\"font-size:10.0pt;\r\ncolor:#333333\">?</span><span lang=\"EN-US\" style=\"font-size:10.0pt;\r\nfont-family:\"Amazon Ember\",serif;color:#333333\">—a perfect mix of trend and\r\ncomfort! Designed with a smooth slip-on style, convenient side zipper </span><span lang=\"EN-US\" style=\"font-size:10.0pt;color:#333333\">?</span><span lang=\"EN-US\" style=\"font-size:10.0pt;font-family:\"Amazon Ember\",serif;color:#333333\">,\r\nand an adjustable strap for the perfect fit, these boots are made to move with\r\nyou. Whether you\'re heading out for a casual day, school run, or weekend\r\nhangout, these boots offer all-day comfort </span><span lang=\"EN-US\" style=\"font-size:10.0pt;color:#333333\">?</span><span lang=\"EN-US\" style=\"font-size:10.0pt;font-family:\"Amazon Ember\",serif;color:#333333\"> and a\r\nstylish edge </span><span lang=\"EN-US\" style=\"font-size:10.0pt;color:#333333\">?.\r\nPair them with jeans, leggings, or a cute dress—no matter the outfit, CREATTOES\r\nhas you looking confident and chic ?</span><span lang=\"EN-US\" style=\"font-size:10.0pt;font-family:\"Amazon Ember\",serif;color:#333333\">.<o:p></o:p></span></p>', '<p style=\"margin: 0in 0in 12pt 12pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:10.0pt;font-family:\r\n\"Amazon Ember\",serif;color:#333333\">Step up your fashion game with the\r\nCREATTOES Women & Girl Boots </span><span lang=\"EN-US\" style=\"font-size:10.0pt;\r\ncolor:#333333\">?</span><span lang=\"EN-US\" style=\"font-size:10.0pt;\r\nfont-family:\"Amazon Ember\",serif;color:#333333\">—a perfect mix of trend and\r\ncomfort! Designed with a smooth slip-on style, convenient side zipper </span><span lang=\"EN-US\" style=\"font-size:10.0pt;color:#333333\">?</span><span lang=\"EN-US\" style=\"font-size:10.0pt;font-family:\"Amazon Ember\",serif;color:#333333\">,\r\nand an adjustable strap for the perfect fit, these boots are made to move with\r\nyou. Whether you\'re heading out for a casual day, school run, or weekend\r\nhangout, these boots offer all-day comfort </span><span lang=\"EN-US\" style=\"font-size:10.0pt;color:#333333\">?</span><span lang=\"EN-US\" style=\"font-size:10.0pt;font-family:\"Amazon Ember\",serif;color:#333333\"> and a\r\nstylish edge </span><span lang=\"EN-US\" style=\"font-size:10.0pt;color:#333333\">?.\r\nPair them with jeans, leggings, or a cute dress—no matter the outfit, CREATTOES\r\nhas you looking confident and chic ?</span><span lang=\"EN-US\" style=\"font-size:10.0pt;font-family:\"Amazon Ember\",serif;color:#333333\">.<o:p></o:p></span></p>', '<p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Times New Roman\",serif;color:#0F1111\">?</span></span><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"> Slip In & Go – No More Hassle! Tired of wasting time with\r\nlaces? Just slip them on and zip up! These boots are made for fast mornings,\r\nlazy afternoons, and stylish days. Simple, sleek, and ready when you are.</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Times New Roman\",serif;color:#0F1111\">?</span></span><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"> Wear It Your Way – Anytime, Anywhere From coffee runs to casual\r\nwalks or weekend adventures, these boots fit every vibe. Dress them up or down\r\n– they match jeans, leggings, dresses, and your everyday confidence.</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Times New Roman\",serif;color:#0F1111\">??</span></span><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"> Made to Last – All-Day Comfort, Every Step Built tough with\r\nsoft cushioning inside and non-slip soles underneath, these boots give you\r\ncomfort you can count on. Walk, run, explore – they’ll keep up with you every\r\nstep of the way!</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;\r\nfont-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Times New Roman\",serif;color:#0F1111\">?</span></span><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"> Sleek Style That Turns Heads Whether you’re headed to class,\r\nthe mall, or just out for fun, these boots upgrade any outfit. From jeans to\r\ndresses, they bring confidence and cool to your everyday look.</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n<span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;line-height:\r\n115%;font-family:\"Times New Roman\",serif;mso-fareast-font-family:Calibri;\r\nmso-fareast-theme-font:minor-latin;color:#0F1111;mso-ansi-language:EN-US;\r\nmso-fareast-language:EN-US;mso-bidi-language:GU\">?</span><span lang=\"EN-US\" style=\"font-size:7.0pt;line-height:115%;font-family:\"Amazon Ember\",serif;\r\nmso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-bidi-font-family:\r\nShruti;mso-bidi-theme-font:minor-bidi;color:#0F1111;mso-ansi-language:EN-US;\r\nmso-fareast-language:EN-US;mso-bidi-language:GU\"> Adjustable Strap = Just the\r\nRight Fit Enjoy a custom fit every time with an adjustable strap that gives you\r\nthe flexibility and support you need. Perfect for growing girls or busy women\r\nwho value both comfort and control.</span></span></p>', '<p class=\"MsoNormal\" style=\"line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:12.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Keep the item in its original condition and packaging\r\nalong with MRP tag and accessories for a successful pick-up.<o:p></o:p></span></p>', '<h1 style=\"margin-top: 0in; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size: 12pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">This\r\nitem is eligible for return within 10 days of delivery. You can also exchange\r\nthis item for a different size/color (based on item availability) or return for\r\na full refund.</span><span lang=\"EN-US\" style=\"font-size:12.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"><br>\r\n<br>\r\n<span style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Please keep the item in its original condition,\r\nwith brand outer box, MRP tags attached, warranty cards, and original\r\naccessories in manufacturer packaging for a successful refund/replacement</span></span><span lang=\"EN-US\" style=\"font-size: 12pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17);\"><o:p></o:p></span></h1>', 1, 0, 1, 13, 7, '2025-07-27 19:57:39');
INSERT INTO `tbl_product` (`p_id`, `p_name`, `p_old_price`, `p_current_price`, `p_qty`, `p_featured_photo`, `p_description`, `p_short_description`, `p_feature`, `p_condition`, `p_return_policy`, `p_total_view`, `p_is_featured`, `p_is_active`, `ecat_id`, `seller_id`, `created_at`) VALUES
(120, 'CLARA 925 Sterling Silver Heart Pendant Necklace', '50000', '34000', 5, 'product-featured-120.png', '<p style=\"margin: 0in 0in 12pt 12pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:10.0pt;font-family:\r\n\"Amazon Ember\",serif;color:#333333\">Pendant with chain Necklace is made in pure\r\n92.5 % Real Sterling Silver. 925 stamp will be on every product. Swiss Zirconia\r\n- As brilliant As Diamond. Sparkle of our specially cut zirconia is very much\r\nequivalent to Real Diamond and even professionals can not differentiate with\r\nnaked eyes whether it is Zirconia or Diamond. 2 Microns Thick Nickel free\r\nRhodium Plating is done to give long lasting shine. Product comes in a very\r\nelegant gift box with CLARA Authenticity Card</span><span lang=\"EN-US\" style=\"font-family:\"Amazon Ember\",serif;color:#333333\">.<o:p></o:p></span></p>', '', '<p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">Sterling\r\nSilver: 92.5 % Pure Real Silver. Stamp will be on product itself.</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">Plating:\r\n2 Microns thick Nickel Free Rhodium Plating for that long lasting Shine.;\r\nChain: 925 Silver Chain provided with this pendant.</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">Packaging:\r\nBeautiful CLARA Box along with Authenticity Card provided for Gifting.</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">Pendant\r\nLength = 18 mm | Pendant Width = 14 mm | Total Weight = 4.8 gms</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">Chain\r\nType: Link</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\r\n\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p>', '<p class=\"MsoNormal\" style=\"line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:12.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Keep the item in its original condition and packaging\r\nalong with MRP tag and accessories for a successful pick-up.<o:p></o:p></span></p>', '<h1 style=\"margin-top: 0in; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size: 12pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">This\r\nitem is eligible for return within 10 days of delivery. You can also exchange\r\nthis item for a different size/color (based on item availability) or return for\r\na full refund.</span><span lang=\"EN-US\" style=\"font-size:12.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"><br>\r\n<br>\r\n<span style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Please keep the item in its original condition,\r\nwith brand outer box, MRP tags attached, warranty cards, and original\r\naccessories in manufacturer packaging for a successful refund/replacement</span></span><span lang=\"EN-US\" style=\"font-size: 12pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17);\"><o:p></o:p></span></h1>', 4, 1, 1, 42, 7, '2025-07-27 20:04:27'),
(121, 'LIBOZA Kurta for Women – Lakhnowi Chikankari Embroidered Ladies Kurti, Stylish Girls Top, Ethnic Full Kurtas, Straight Design Kurtis for Woman', '3500', '2000', 3, 'product-featured-121.png', '<p class=\"MsoNormal\"><span lang=\"EN-US\">The lightweight and breathable fabric\r\nprovides unmatched comfort, whether you\'re wearing it to work, casual outings,\r\nor festive events. Pair it with palazzos, leggings, or even jeans for a\r\nversatile look that exudes elegance and style. With this kurta, experience the\r\nperfect harmony of tradition and modernity.<o:p></o:p></span></p>', '', '<p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">1.\r\nELEGANT LUCKNOWI CHIKANKARI: Discover timeless charm with our intricately\r\ncrafted Lucknowi straight chikankari embroidery, adding grace to every\r\noccasion.</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\r\n\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">2.\r\nCOMFORTABLE RAYON FABRIC: Experience unparalleled comfort with our premium\r\nRayon fabric, perfect for daily wear, office, and festive celebrations.</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">3.\r\nVERSATILE PARTY/OFFICE WEAR: Effortlessly transition from office to a party\r\nwith these readymade kurtis, striking the balance between style and\r\nversatility.</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\r\n\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 9pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:7.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">4.\r\nETHNIC DESIGN EXCLUSIVITY: Unleash your cultural diva with ethnic designs that\r\nblend tradition seamlessly, making a statement at weddings and festive\r\ngatherings.</span></span><span lang=\"EN-US\" style=\"font-size:7.0pt;font-family:\r\n\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n<span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:7.0pt;line-height:\r\n115%;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:Calibri;\r\nmso-fareast-theme-font:minor-latin;mso-bidi-font-family:Shruti;mso-bidi-theme-font:\r\nminor-bidi;color:#0F1111;mso-ansi-language:EN-US;mso-fareast-language:EN-US;\r\nmso-bidi-language:GU\">5. PERFECT FIT FOR ALL OCCASIONS: Elevate your wardrobe\r\nwith our kurta collection, offering a perfect fit for ladies and girls,\r\nensuring you shine in every moment.</span></span></p>', '<p><span lang=\"EN-US\" style=\"font-size:12.0pt;line-height:\r\n115%;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";\r\nmso-bidi-font-family:\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt;\r\nmso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:GU\">Keep\r\nthe item in its original condition and packaging along with MRP tag and\r\naccessories for a successful pick-up.</span></p>', '<h1 style=\"margin-top: 0in; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size: 12pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">This\r\nitem is eligible for return within 10 days of delivery. You can also exchange\r\nthis item for a different size/color (based on item availability) or return for\r\na full refund.</span><span lang=\"EN-US\" style=\"font-size:12.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\"><br>\r\n<br>\r\n<span style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Please keep the item in its original condition,\r\nwith brand outer box, MRP tags attached, warranty cards, and original\r\naccessories in manufacturer packaging for a successful refund/replacement</span></span><span lang=\"EN-US\" style=\"font-size: 12pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17);\"><o:p></o:p></span></h1>', 0, 1, 1, 32, 7, '2025-07-27 20:06:11'),
(122, 'Skybags Dino 01 School Backpack Purple', '2499', '2100', 3, 'product-featured-122.png', '<p class=\"MsoNormal\" style=\"margin-bottom: 0.0001pt; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\r\n\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";mso-bidi-font-family:\r\n\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\">2 SPACIOUS COMPARTMENTSTO\r\nCARRY YOUR ESSENTIALS WELL-ORGANIZED<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-bottom: 0.0001pt; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\r\n\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";mso-bidi-font-family:\r\n\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\">FABRIC BOTTLE\r\nPOCKETALWAYS STAY HYDRATED PADDED <o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-bottom: 0.0001pt; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\r\n\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";mso-bidi-font-family:\r\n\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\"> </span></p><p class=\"MsoNormal\" style=\"margin-bottom: 0.0001pt; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\r\n\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";mso-bidi-font-family:\r\n\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\">GRAB HANDLEFOR EASY\r\nHANDLING <o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-bottom: 0.0001pt; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\r\n\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";mso-bidi-font-family:\r\n\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\"> </span></p><p class=\"MsoNormal\" style=\"margin-bottom: 0.0001pt; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\r\n\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";mso-bidi-font-family:\r\n\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\">BUILT TO LAST STRAPSFOR\r\nLONG TERM USAGE<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-bottom: 0.0001pt; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\r\n\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";mso-bidi-font-family:\r\n\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\"> </span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\" style=\"margin-bottom: 0.0001pt; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\r\n\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";mso-bidi-font-family:\r\n\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\">???????KS THAT KEEP YOU\r\nENTERTAINED ALL THE TIME<o:p></o:p></span></p>', '<p class=\"MsoNormal\" style=\"margin-bottom: 0.0001pt; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\r\n\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";mso-bidi-font-family:\r\n\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\">2 SPACIOUS COMPARTMENTSTO\r\nCARRY YOUR ESSENTIALS WELL-ORGANIZED<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-bottom: 0.0001pt; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\r\n\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";mso-bidi-font-family:\r\n\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\">FABRIC BOTTLE\r\nPOCKETALWAYS STAY HYDRATED PADDED <o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-bottom: 0.0001pt; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\r\n\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";mso-bidi-font-family:\r\n\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\"> </span></p><p class=\"MsoNormal\" style=\"margin-bottom: 0.0001pt; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\r\n\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";mso-bidi-font-family:\r\n\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\">GRAB HANDLEFOR EASY\r\nHANDLING <o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-bottom: 0.0001pt; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\r\n\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";mso-bidi-font-family:\r\n\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\"> </span></p><p class=\"MsoNormal\" style=\"margin-bottom: 0.0001pt; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\r\n\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";mso-bidi-font-family:\r\n\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\">BUILT TO LAST STRAPSFOR\r\nLONG TERM USAGE<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-bottom: 0.0001pt; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\r\n\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";mso-bidi-font-family:\r\n\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\"> </span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\" style=\"margin-bottom: 0.0001pt; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\r\n\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";mso-bidi-font-family:\r\n\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\">???????KS THAT KEEP YOU\r\nENTERTAINED ALL THE TIME<o:p></o:p></span></p>', '<p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:6.5pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">2 Main\r\nCompartment Grab handle Padded Shoulder Strap 1 Year International Warranty</span></span><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p>', '<p class=\"MsoNormal\" style=\"line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:12.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Keep the item in its original condition and packaging\r\nalong with MRP tag and accessories for a successful pick-up.<o:p></o:p></span></p>', '<h1 style=\"margin-top: 0in; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size: 10pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">This item is eligible for return within 10 days of\r\ndelivery. You can also exchange this item for a different size/color (based on\r\nitem availability) or return for a full refund.</span><span lang=\"EN-US\" style=\"font-size: 10pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17);\"><br>\r\n<br>\r\n<span style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Please keep the item in its original condition,\r\nwith brand outer box, MRP tags attached, warranty cards, and original\r\naccessories in manufacturer packaging for a successful refund/replacement<o:p></o:p></span></span></h1>', 0, 0, 1, 30, 8, '2025-07-27 20:18:14'),
(123, 'Alan Jones Clothing Boys Oversized Cotton Printed T-Shirt ', '2499', '2000', 2, 'product-featured-123.png', '<p style=\"margin: 0in 0in 12pt 12pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:10.0pt;font-family:\r\n\"Amazon Ember\",serif;color:#333333\">Give your child\'s wardrobe a trendy update\r\nwith the Alan Jones Clothing Boys Oversized Printed T-Shirt. Crafted from a\r\nsoft and breathable cotton blend (80% cotton, 20% polyester), this t-shirt\r\nensures superior comfort whether he\'s at school, at home, or out with friends.\r\nThe oversized fit gives it a relaxed, modern look, while the stylish printed\r\ngraphic adds a splash of youthful energy. Designed with a round neck and ribbed\r\ncollar, this tee offers both durability and shape retention wash after wash.\r\nThe short sleeves and lightweight fabric make it perfect for all seasons wear\r\nit on its own in summer or layer it under a jacket during cooler months. Pair\r\nit with jeans, joggers, or shorts for a complete casual outfit your kid will\r\nlove to wear again and again</span><span lang=\"EN-US\" style=\"font-family:\"Amazon Ember\",serif;\r\ncolor:#333333\">.<o:p></o:p></span></p>', '', '<p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:6.5pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111;\r\nmso-font-kerning:0pt\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:6.5pt;\r\nmso-bidi-font-size:11.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Comfortable Cotton Blend - Made with a breathable 80%\r\ncotton and 20% polyester fabric, this boys t-shirt offers day-long comfort and\r\ndurability for active wear.</span><span lang=\"EN-US\" style=\"font-size:6.5pt;\r\nfont-family:\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";\r\nmso-bidi-font-family:\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:6.5pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111;\r\nmso-font-kerning:0pt\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:6.5pt;\r\nmso-bidi-font-size:11.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Trendy Oversized Fit - Designed with a modern oversized\r\nsilhouette, perfect for a relaxed and stylish look that suits everyday casual\r\nor sporty outfits.</span><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\r\n\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";mso-bidi-font-family:\r\n\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:6.5pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111;\r\nmso-font-kerning:0pt\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:6.5pt;\r\nmso-bidi-font-size:11.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Stylish Printed Design - Features a cool graphic print\r\nthat adds a fun and youthful vibe, making it a go-to choice for school,\r\nplaydates, or casual outings.</span><span lang=\"EN-US\" style=\"font-size:6.5pt;\r\nfont-family:\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";\r\nmso-bidi-font-family:\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:6.5pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111;\r\nmso-font-kerning:0pt\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:6.5pt;\r\nmso-bidi-font-size:11.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Round Neck with Ribbed Finish - The classic round\r\nneckline with ribbed detailing enhances comfort and ensures the tee retains its\r\nshape after multiple washes.</span><span lang=\"EN-US\" style=\"font-size:6.5pt;\r\nfont-family:\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";\r\nmso-bidi-font-family:\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\"><o:p></o:p></span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:6.5pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111;\r\nmso-font-kerning:0pt\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:6.5pt;\r\nmso-bidi-font-size:11.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Easy to Style & Maintain - Pairs effortlessly with\r\njeans, joggers, or shorts; machine washable for easy care, ideal for busy\r\nparents and playful kids.</span><span lang=\"EN-US\" style=\"font-size:6.5pt;\r\nfont-family:\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";\r\nmso-bidi-font-family:\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\"><o:p></o:p></span></p>', '<p class=\"MsoNormal\" style=\"line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:12.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Keep the item in its original condition and packaging\r\nalong with MRP tag and accessories for a successful pick-up.<o:p></o:p></span></p>', '<p><b><span lang=\"EN-US\" style=\"font-size: 10pt; line-height: 115%; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">This item is eligible for return within 10 days of\r\ndelivery. You can also exchange this item for a different size/color (based on\r\nitem availability) or return for a full refund.</span></b></p>', 1, 1, 1, 26, 8, '2025-07-27 20:19:40');
INSERT INTO `tbl_product` (`p_id`, `p_name`, `p_old_price`, `p_current_price`, `p_qty`, `p_featured_photo`, `p_description`, `p_short_description`, `p_feature`, `p_condition`, `p_return_policy`, `p_total_view`, `p_is_featured`, `p_is_active`, `ecat_id`, `seller_id`, `created_at`) VALUES
(124, 'Niren Enterprise Hornbill Floral Printed Purple Color Baby Frock with Long Sleeve Knee-Length and Round Color Style', '2300', '1900', 4, 'product-featured-124.png', '<p class=\"a-spacing-base\" style=\"margin-top: 0in; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:9.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\">Niren Enterprise</span></span><span lang=\"EN-US\" style=\"font-size:\r\n9.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"> is a brand of\r\nchildren’s clothing and accessories. Our product positioning is in the elegant\r\nprincess casual dress and formal party dress.<o:p></o:p></span></p><p class=\"a-spacing-base\" style=\"margin-top: 0in; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:9.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">We\r\nbelieve that \'\'Every girl can be a princess\'\', and in order to realize the\r\ndream of every little girl into a princess, we keep unremitting efforts.<o:p></o:p></span></p><p>\r\n\r\n\r\n\r\n</p><p class=\"a-spacing-base\" style=\"margin-top: 0in; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:9.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">Every\r\ngirl has a princess dream; adorable and sparkling dresses will make them much\r\nmore beautiful and happy</span><span lang=\"EN-US\" style=\"font-size:6.5pt;\r\nfont-family:\"Amazon Ember\",serif;color:#0F1111\">.<o:p></o:p></span></p>', '<p class=\"a-spacing-base\" style=\"margin-top: 0in; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span class=\"a-text-bold\"><span lang=\"EN-US\" style=\"font-size:9.0pt;font-family:\"Amazon Ember\",serif;\r\ncolor:#0F1111\">Niren Enterprise</span></span><span lang=\"EN-US\" style=\"font-size:\r\n9.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"> is a brand of\r\nchildren’s clothing and accessories. Our product positioning is in the elegant\r\nprincess casual dress and formal party dress.<o:p></o:p></span></p><p class=\"a-spacing-base\" style=\"margin-top: 0in; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:9.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">We\r\nbelieve that \'\'Every girl can be a princess\'\', and in order to realize the\r\ndream of every little girl into a princess, we keep unremitting efforts.<o:p></o:p></span></p><p>\r\n\r\n\r\n\r\n</p><p class=\"a-spacing-base\" style=\"margin-top: 0in; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:9.0pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">Every\r\ngirl has a princess dream; adorable and sparkling dresses will make them much\r\nmore beautiful and happy</span><span lang=\"EN-US\" style=\"font-size:6.5pt;\r\nfont-family:\"Amazon Ember\",serif;color:#0F1111\">.<o:p></o:p></span></p>', '<p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:6.5pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111;\r\nmso-font-kerning:0pt\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:6.5pt;\r\nmso-bidi-font-size:11.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Material: Made of high quality Modal. Super soft and\r\ncomfortable. Skin-friendly and breathable, no harm for your baby\'s delicate\r\nskin.</span><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\"Amazon Ember\",serif;\r\nmso-fareast-font-family:\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";\r\ncolor:#0F1111;mso-font-kerning:0pt\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:6.5pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111;\r\nmso-font-kerning:0pt\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:6.5pt;\r\nmso-bidi-font-size:11.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Ironing after receiving the frock for a good look.</span><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:6.5pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111;\r\nmso-font-kerning:0pt\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:6.5pt;\r\nmso-bidi-font-size:11.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Design: Sweet color and chic style, make this infant\r\nclothes set looks attractive and fascinating. Your little one will get tons of\r\ncompliments in it.</span><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\r\n\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";mso-bidi-font-family:\r\n\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:6.5pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111;\r\nmso-font-kerning:0pt\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:6.5pt;\r\nmso-bidi-font-size:11.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Your baby will like it as a gift for first birthday,\r\nChristmas, or other holidays.</span><span lang=\"EN-US\" style=\"font-size:6.5pt;\r\nfont-family:\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";\r\nmso-bidi-font-family:\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:6.5pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111;\r\nmso-font-kerning:0pt\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:6.5pt;\r\nmso-bidi-font-size:11.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Occasion: Suitable for casual, home wear, play wear,\r\nphoto shoot, family gathering, holiday, church, birthday, baptism, picnic,\r\ncelebration and so on.</span><span lang=\"EN-US\" style=\"font-size:6.5pt;\r\nfont-family:\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";\r\nmso-bidi-font-family:\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\"><o:p></o:p></span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:6.5pt;mso-bidi-font-size:11.0pt;font-family:\"Amazon Ember\",serif;\r\nmso-fareast-font-family:\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";\r\ncolor:#0F1111;mso-font-kerning:0pt\"> </span></p>', '<p class=\"MsoNormal\" style=\"line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:12.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Keep the item in its original condition and packaging\r\nalong with MRP tag and accessories for a successful pick-up.<o:p></o:p></span></p>', '<h1 style=\"margin-top: 0in; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size: 10pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">This item is eligible for return within 10 days of\r\ndelivery. You can also exchange this item for a different size/color (based on\r\nitem availability) or return for a full refund.</span><span lang=\"EN-US\" style=\"font-size: 10pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17);\"><br>\r\n<br>\r\n<span style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Please keep the item in its original condition,\r\nwith brand outer box, MRP tags attached, warranty cards, and original\r\naccessories in manufacturer packaging for a successful refund/replacement<o:p></o:p></span></span></h1>', 0, 0, 1, 27, 8, '2025-07-27 20:20:53'),
(125, 'BABY GO Full Sleeves Designer Clothing Set for Baby Girls', '10,000', '9,000', 12, 'product-featured-125.png', '<p style=\"margin: 0in 0in 12pt 12pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-family:\"Amazon Ember\",serif;\r\ncolor:#333333\">Dress up your little one in BabyGo’s exclusive baby boy and baby\r\ngirl t-shirt top and pant set, designed for utmost comfort and style. Crafted\r\nfrom premium quality 100% cotton, these sets ensure breathable softness against\r\nyour baby\'s delicate skin. Explore our wide collection of vibrant colors,\r\ntrendy prints, and adorable patterns that cater to every taste. Mix and match\r\ntops and bottoms to create endless outfit possibilities. Say goodbye to boring\r\nbaby clothes and embrace our stylish yet cozy baby sets today!<o:p></o:p></span></p>', '<p style=\"margin: 0in 0in 12pt 12pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-family:\"Amazon Ember\",serif;\r\ncolor:#333333\">Dress up your little one in BabyGo’s exclusive baby boy and baby\r\ngirl t-shirt top and pant set, designed for utmost comfort and style. Crafted\r\nfrom premium quality 100% cotton, these sets ensure breathable softness against\r\nyour baby\'s delicate skin. Explore our wide collection of vibrant colors,\r\ntrendy prints, and adorable patterns that cater to every taste. Mix and match\r\ntops and bottoms to create endless outfit possibilities. Say goodbye to boring\r\nbaby clothes and embrace our stylish yet cozy baby sets today!<o:p></o:p></span></p>', '<p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:8.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111;\r\nmso-font-kerning:0pt\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:8.0pt;\r\nfont-family:\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";\r\nmso-bidi-font-family:\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\">100%\r\nPURE COTTON: BABY GO Top & Bottom Wear/ Clothing Set for Baby Boys &\r\nGirls, Infants, New Born are very comfortable and are made up of 100% pure\r\ncotton.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:8.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111;\r\nmso-font-kerning:0pt\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:8.0pt;\r\nfont-family:\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";\r\nmso-bidi-font-family:\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\">Clothing\r\nSets are easy to wear / easy for nappy changes dressing and diapering.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:8.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111;\r\nmso-font-kerning:0pt\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:8.0pt;\r\nfont-family:\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";\r\nmso-bidi-font-family:\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\">BABY\r\nGO clothing is breathable cool skin-friendly soft and comfortable for Babies.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:8.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111;\r\nmso-font-kerning:0pt\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:8.0pt;\r\nfont-family:\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";\r\nmso-bidi-font-family:\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\">Our\r\nbaby clothes are available in dazzling colors & designs. We have made a\r\nconsistent effort to make the colors and finishes similar to the image of the\r\nproducts you.<o:p></o:p></span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:8.0pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111;\r\nmso-font-kerning:0pt\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:8.0pt;\r\nfont-family:\"Amazon Ember\",serif;mso-fareast-font-family:\"Times New Roman\";\r\nmso-bidi-font-family:\"Times New Roman\";color:#0F1111;mso-font-kerning:0pt\">Occasion\r\n: Suitable for daily wear / first birthday / outdoor sports / photography /\r\nbirthday gift / party / baby shower / sleeping nightwear / home playwear /\r\nvacation / beach or any occasion.<o:p></o:p></span></p>', '<p class=\"MsoNormal\" style=\"line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:12.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Keep the item in its original condition and packaging\r\nalong with MRP tag and accessories for a successful pick-up.<o:p></o:p></span></p>', '<h1 style=\"margin-top: 0in; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size: 10pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">This item is eligible for return within 10 days of\r\ndelivery. You can also exchange this item for a different size/color (based on\r\nitem availability) or return for a full refund.</span><span lang=\"EN-US\" style=\"font-size: 10pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17);\"><br>\r\n<br>\r\n<span style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Please keep the item in its original condition,\r\nwith brand outer box, MRP tags attached, warranty cards, and original\r\naccessories in manufacturer packaging for a successful refund/replacement<o:p></o:p></span></span></h1>', 1, 0, 1, 26, 8, '2025-07-27 20:22:15'),
(126, 'HOOH Baby Walking Shoes with Whistle Sound, Slip-on Knit Breathable Shoes for Baby Boys & Girls', '50000', '45000', 3, 'product-featured-126.png', '<p style=\"margin: 0in 0in 12pt 12pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:10.0pt;font-family:\r\n\"Amazon Ember\",serif;color:#333333\">Introducing these delightful walking shoes\r\nfor little ones aged 0-24 months that combine fun with functionality! The navy\r\nblue and red colour combination creates an appealing sporty look, while the\r\nknitted upper material ensures excellent breathability for tiny feet. These\r\nslip-on shoes feature a unique whistle sound mechanism that adds an\r\nentertaining element to every step your little one takes. The ultra-soft insole\r\nprovides superior comfort, making them perfect for babies learning to walk. The\r\nlightweight design with a flexible red sole supports natural foot movement and\r\ndevelopment. The mesh-like knit construction allows proper air circulation,\r\nkeeping your baby\'s feet cool and comfortable throughout the day. These shoes\r\nare thoughtfully designed with an easy slip-on style, making them practical for\r\nparents during quick changes. The charming panda-inspired decorative button\r\nadds a playful touch to these already adorable shoes. Perfect for both indoor\r\nand outdoor use, these shoes are an ideal choice for your little one\'s early\r\nwalking adventures.<o:p></o:p></span></p>', '<p style=\"margin: 0in 0in 12pt 12pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:10.0pt;font-family:\r\n\"Amazon Ember\",serif;color:#333333\">Introducing these delightful walking shoes\r\nfor little ones aged 0-24 months that combine fun with functionality! The navy\r\nblue and red colour combination creates an appealing sporty look, while the\r\nknitted upper material ensures excellent breathability for tiny feet. These\r\nslip-on shoes feature a unique whistle sound mechanism that adds an\r\nentertaining element to every step your little one takes. The ultra-soft insole\r\nprovides superior comfort, making them perfect for babies learning to walk. The\r\nlightweight design with a flexible red sole supports natural foot movement and\r\ndevelopment. The mesh-like knit construction allows proper air circulation,\r\nkeeping your baby\'s feet cool and comfortable throughout the day. These shoes\r\nare thoughtfully designed with an easy slip-on style, making them practical for\r\nparents during quick changes. The charming panda-inspired decorative button\r\nadds a playful touch to these already adorable shoes. Perfect for both indoor\r\nand outdoor use, these shoes are an ideal choice for your little one\'s early\r\nwalking adventures.<o:p></o:p></span></p>', '<p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:6.5pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">WHISTLE FEATURE:\r\nInnovative design with built-in whistle that makes a fun sound while walking,\r\nencouraging baby\'s mobility and entertainment</span></span><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:6.5pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">COMFORT\r\nDESIGN: Ultra-soft insole with breathable knit upper material ensures maximum\r\ncomfort for little feet during daily activities</span></span><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:6.5pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">SLIP-ON\r\nSTYLE: Easy-to-wear design with stretchy knit material makes putting on and\r\ntaking off hassle-free for parents</span></span><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:6.5pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">AGE\r\nRANGE: Specially designed for infants and toddlers from 0 to 24 months, perfect\r\nfor early walking stages</span></span><span lang=\"EN-US\" style=\"font-size:6.5pt;\r\nfont-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:6.5pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">SAFETY\r\nFEATURES: Non-slip red rubber sole with navy blue upper provides secure grip\r\nand stability for developing walkers</span></span><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p>', '<p class=\"MsoNormal\" style=\"line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:12.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Keep the item in its original condition and packaging\r\nalong with MRP tag and accessories for a successful pick-up.<o:p></o:p></span></p>', '<h1 style=\"margin-top: 0in; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size: 10pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">This item is eligible for return within 10 days of\r\ndelivery. You can also exchange this item for a different size/color (based on\r\nitem availability) or return for a full refund.</span><span lang=\"EN-US\" style=\"font-size: 10pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17);\"><br>\r\n<br>\r\n<span style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Please keep the item in its original condition,\r\nwith brand outer box, MRP tags attached, warranty cards, and original\r\naccessories in manufacturer packaging for a successful refund/replacement<o:p></o:p></span></span></h1>', 3, 0, 1, 28, 8, '2025-07-27 20:23:37'),
(127, 'ON TIME OCTUS Kids Analouge Multi-Color Light Cute 3D Cartoon Character Boys and Girls Watch (Multicolour Dial & Colored Strap)', '34000', '22000', 2, 'product-featured-127.png', '<p style=\"margin: 0in 0in 12pt 12pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:10.0pt;font-family:\r\n\"Amazon Ember\",serif;color:#333333\">Introducing the whimsical and vibrant Kids\'\r\nCartoon Character Analog Watch, a delightful timepiece designed to bring joy\r\nand functionality to young hearts. This watch features a playful and iconic\r\ncartoon character that captures the imagination of children and adds a touch of\r\nfun to their daily routines. The watch face is a colorful canvas where the\r\ncartoon character comes to life. With expressive eyes, a cheerful smile, and\r\nanimated gestures, the character seems ready to jump off the watch and join\r\nyour child\'s adventures. The numbers on the watch are clear and easy to read,\r\nmaking it perfect for kids who are just learning to tell time</span><span lang=\"EN-US\" style=\"font-family:\"Amazon Ember\",serif;color:#333333\">.<o:p></o:p></span></p>', '<p style=\"margin: 0in 0in 12pt 12pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:10.0pt;font-family:\r\n\"Amazon Ember\",serif;color:#333333\">Introducing the whimsical and vibrant Kids\'\r\nCartoon Character Analog Watch, a delightful timepiece designed to bring joy\r\nand functionality to young hearts. This watch features a playful and iconic\r\ncartoon character that captures the imagination of children and adds a touch of\r\nfun to their daily routines. The watch face is a colorful canvas where the\r\ncartoon character comes to life. With expressive eyes, a cheerful smile, and\r\nanimated gestures, the character seems ready to jump off the watch and join\r\nyour child\'s adventures. The numbers on the watch are clear and easy to read,\r\nmaking it perfect for kids who are just learning to tell time</span><span lang=\"EN-US\" style=\"font-family:\"Amazon Ember\",serif;color:#333333\">.<o:p></o:p></span></p>', '<p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:6.5pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">Dial\r\nColor : Multi, Case Color : Clear, Strap Color : Multi</span></span><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:6.5pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">Case\r\nDimension : Width 37 mm, Height 36 mm, Thickness 13 mm, Strap Dimension: 16 mm</span></span><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:6.5pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">Case\r\nmaterial : Plastic, Strap Material : Resin, Clasp Type : Buckle</span></span><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\" style=\"margin: 0in 0in 0.0001pt 8.3pt; text-indent: -0.25in; line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-size:10.0pt;mso-bidi-font-size:6.5pt;font-family:Symbol;\r\nmso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol;color:#0F1111\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \"Times New Roman\";\">      \r\n</span></span><!--[endif]--><span class=\"a-list-item\"><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\"Amazon Ember\",serif;color:#0F1111\">Display\r\nType : Analogue, Movement Type : Quartz</span></span><span lang=\"EN-US\" style=\"font-size:6.5pt;font-family:\"Amazon Ember\",serif;color:#0F1111\"><o:p></o:p></span></p>', '<p class=\"MsoNormal\" style=\"line-height: normal; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size:12.0pt;font-family:\"Amazon Ember\",serif;mso-fareast-font-family:\r\n\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\";color:#0F1111;\r\nmso-font-kerning:0pt\">Keep the item in its original condition and packaging\r\nalong with MRP tag and accessories for a successful pick-up.<o:p></o:p></span></p>', '<h1 style=\"margin-top: 0in; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span lang=\"EN-US\" style=\"font-size: 10pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">This item is eligible for return within 10 days of\r\ndelivery. You can also exchange this item for a different size/color (based on\r\nitem availability) or return for a full refund.</span><span lang=\"EN-US\" style=\"font-size: 10pt; font-family: \"Amazon Ember\", serif; color: rgb(15, 17, 17);\"><br>\r\n<br>\r\n<span style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Please keep the item in its original condition,\r\nwith brand outer box, MRP tags attached, warranty cards, and original\r\naccessories in manufacturer packaging for a successful refund/replacement<o:p></o:p></span></span></h1>', 1, 1, 1, 30, 8, '2025-07-27 20:25:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_color`
--

CREATE TABLE `tbl_product_color` (
  `id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_product_color`
--

INSERT INTO `tbl_product_color` (`id`, `color_id`, `p_id`) VALUES
(69, 1, 4),
(70, 4, 4),
(77, 6, 6),
(82, 2, 12),
(83, 9, 13),
(84, 3, 14),
(85, 2, 15),
(86, 6, 15),
(87, 3, 16),
(88, 3, 17),
(89, 2, 18),
(90, 3, 19),
(91, 1, 20),
(92, 8, 21),
(93, 2, 22),
(94, 2, 23),
(95, 2, 25),
(96, 5, 26),
(97, 2, 27),
(98, 4, 27),
(99, 5, 28),
(100, 7, 29),
(101, 10, 30),
(102, 11, 31),
(103, 14, 32),
(105, 2, 34),
(106, 1, 35),
(107, 3, 36),
(109, 6, 38),
(110, 2, 39),
(111, 11, 42),
(149, 3, 10),
(150, 6, 9),
(151, 3, 8),
(152, 7, 7),
(159, 2, 77),
(163, 17, 79),
(164, 2, 78),
(167, 3, 80),
(168, 2, 81),
(172, 1, 82),
(173, 2, 82),
(174, 4, 82),
(292, 2, 111),
(294, 3, 119),
(295, 6, 119),
(298, 2, 117),
(299, 3, 117),
(300, 3, 116),
(301, 4, 116),
(302, 2, 114),
(303, 3, 114),
(305, 3, 112),
(313, 4, 126),
(314, 2, 125),
(315, 6, 124),
(317, 2, 122),
(318, 3, 113),
(319, 4, 121),
(321, 1, 120),
(322, 2, 120),
(323, 3, 120),
(324, 1, 110),
(325, 2, 123),
(326, 2, 118),
(327, 5, 118),
(328, 2, 115),
(329, 3, 115),
(330, 3, 127);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_photo`
--

CREATE TABLE `tbl_product_photo` (
  `pp_id` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `p_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_product_photo`
--

INSERT INTO `tbl_product_photo` (`pp_id`, `photo`, `p_id`) VALUES
(133, '133.png', 109),
(134, '134.png', 111),
(135, '135.png', 112),
(136, '136.png', 113),
(137, '137.png', 114),
(138, '138.png', 115),
(139, '139.png', 116),
(140, '140.png', 117),
(141, '141.png', 118),
(142, '142.png', 119),
(143, '143.png', 120),
(144, '144.png', 121),
(145, '145.png', 122),
(146, '146.png', 123),
(147, '147.png', 124),
(148, '148.png', 125),
(149, '149.png', 126),
(150, '150.png', 127);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_size`
--

CREATE TABLE `tbl_product_size` (
  `id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_product_size`
--

INSERT INTO `tbl_product_size` (`id`, `size_id`, `p_id`) VALUES
(44, 1, 6),
(56, 8, 12),
(57, 9, 12),
(58, 10, 12),
(59, 11, 12),
(60, 12, 12),
(61, 13, 12),
(62, 9, 13),
(63, 11, 13),
(64, 13, 13),
(65, 15, 13),
(66, 9, 14),
(67, 11, 14),
(68, 12, 14),
(69, 13, 14),
(70, 9, 15),
(71, 11, 15),
(72, 13, 15),
(73, 15, 16),
(74, 16, 16),
(75, 17, 16),
(76, 16, 17),
(77, 17, 17),
(78, 14, 18),
(79, 15, 18),
(80, 16, 18),
(81, 17, 18),
(82, 15, 19),
(83, 16, 19),
(84, 17, 19),
(85, 14, 20),
(86, 15, 20),
(87, 17, 20),
(88, 15, 21),
(89, 17, 21),
(90, 15, 22),
(91, 16, 22),
(92, 17, 22),
(93, 15, 23),
(94, 16, 23),
(95, 17, 23),
(96, 18, 25),
(97, 19, 25),
(98, 20, 25),
(99, 21, 25),
(100, 19, 26),
(101, 21, 26),
(102, 22, 26),
(103, 23, 26),
(104, 19, 27),
(105, 20, 27),
(106, 21, 27),
(107, 22, 27),
(108, 19, 28),
(109, 20, 28),
(110, 21, 28),
(111, 19, 29),
(112, 20, 29),
(113, 22, 29),
(114, 1, 30),
(115, 2, 30),
(116, 3, 30),
(117, 4, 30),
(118, 23, 31),
(119, 26, 32),
(123, 2, 34),
(124, 2, 35),
(125, 2, 36),
(126, 3, 36),
(129, 2, 38),
(130, 3, 38),
(131, 4, 38),
(132, 5, 38),
(133, 27, 39),
(134, 8, 42),
(210, 3, 10),
(211, 4, 10),
(212, 5, 10),
(213, 6, 10),
(214, 3, 9),
(215, 4, 9),
(216, 3, 8),
(217, 4, 8),
(218, 2, 7),
(219, 3, 7),
(220, 4, 7),
(249, 1, 79),
(250, 2, 79),
(251, 3, 79),
(252, 1, 78),
(253, 2, 78),
(254, 3, 78),
(255, 4, 78),
(256, 5, 78),
(259, 26, 80),
(262, 3, 82),
(263, 4, 82),
(475, 3, 111),
(477, 2, 119),
(478, 3, 119),
(479, 4, 119),
(482, 2, 117),
(483, 3, 117),
(484, 5, 117),
(485, 2, 116),
(486, 4, 116),
(487, 2, 114),
(488, 3, 114),
(489, 4, 114),
(492, 3, 112),
(500, 3, 126),
(501, 2, 125),
(502, 3, 124),
(504, 2, 122),
(505, 3, 113),
(506, 4, 113),
(507, 2, 121),
(509, 3, 123),
(510, 2, 118),
(511, 4, 118),
(512, 2, 115),
(513, 3, 115),
(514, 3, 127);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rating`
--

CREATE TABLE `tbl_rating` (
  `rt_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `comment` text NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_rating`
--

INSERT INTO `tbl_rating` (`rt_id`, `p_id`, `cust_id`, `subject`, `created_at`, `comment`, `rating`) VALUES
(22, 118, 24, 'test', '2025-08-04 10:17:42', 'sgd', 4),
(23, 115, 26, 'good', '2025-08-04 18:35:49', 'good tshirt', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_service`
--

CREATE TABLE `tbl_service` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_service`
--

INSERT INTO `tbl_service` (`id`, `title`, `content`, `photo`) VALUES
(5, 'Easy Returns', 'Return any item before 15 days!', 'service-5.png'),
(6, 'Free Shipping', 'Enjoy free shipping inside US.', 'service-6.png'),
(7, 'Fast Shipping', 'Items are shipped within 24 hours.', 'service-7.png'),
(8, 'Satisfaction Guarantee', 'We guarantee you with our quality satisfaction.', 'service-8.png'),
(9, 'Secure Checkout', 'Providing Secure Checkout Options for all', 'service-9.png'),
(10, 'Money Back Guarantee', 'Offer money back guarantee on our products', 'service-10.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `id` int(11) NOT NULL,
  `logo` text DEFAULT NULL,
  `favicon` text DEFAULT NULL,
  `footer_about` text DEFAULT NULL,
  `footer_copyright` text DEFAULT NULL,
  `contact_address` text DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `contact_fax` varchar(255) DEFAULT NULL,
  `contact_map_iframe` text DEFAULT NULL,
  `receive_email` varchar(255) DEFAULT NULL,
  `receive_email_subject` varchar(255) DEFAULT NULL,
  `receive_email_thank_you_message` text DEFAULT NULL,
  `forget_password_message` text DEFAULT NULL,
  `total_recent_post_footer` int(10) DEFAULT 0,
  `total_popular_post_footer` int(10) DEFAULT 0,
  `total_recent_post_sidebar` int(11) DEFAULT 0,
  `total_popular_post_sidebar` int(11) DEFAULT 0,
  `total_featured_product_home` int(11) DEFAULT 0,
  `total_latest_product_home` int(11) DEFAULT 0,
  `total_popular_product_home` int(11) DEFAULT 0,
  `meta_title_home` text DEFAULT NULL,
  `meta_keyword_home` text DEFAULT NULL,
  `meta_description_home` text DEFAULT NULL,
  `banner_login` text DEFAULT NULL,
  `banner_registration` text DEFAULT NULL,
  `banner_forget_password` text DEFAULT NULL,
  `banner_reset_password` text DEFAULT NULL,
  `banner_search` text DEFAULT NULL,
  `banner_cart` text DEFAULT NULL,
  `banner_checkout` text DEFAULT NULL,
  `banner_product_category` text DEFAULT NULL,
  `banner_seller_login` text DEFAULT NULL,
  `banner_seller_registration` text DEFAULT NULL,
  `banner_blog` text DEFAULT NULL,
  `cta_title` text DEFAULT NULL,
  `cta_content` text DEFAULT NULL,
  `cta_read_more_text` text DEFAULT NULL,
  `cta_read_more_url` text DEFAULT NULL,
  `cta_photo` text DEFAULT NULL,
  `featured_product_title` text DEFAULT NULL,
  `featured_product_subtitle` text DEFAULT NULL,
  `latest_product_title` text DEFAULT NULL,
  `latest_product_subtitle` text DEFAULT NULL,
  `popular_product_title` text DEFAULT NULL,
  `popular_product_subtitle` text DEFAULT NULL,
  `testimonial_title` text DEFAULT NULL,
  `testimonial_subtitle` text DEFAULT NULL,
  `testimonial_photo` text DEFAULT NULL,
  `blog_title` text DEFAULT NULL,
  `blog_subtitle` text DEFAULT NULL,
  `newsletter_text` text DEFAULT NULL,
  `paypal_email` varchar(255) DEFAULT NULL,
  `stripe_public_key` varchar(255) DEFAULT NULL,
  `stripe_secret_key` varchar(255) DEFAULT NULL,
  `bank_detail` text DEFAULT NULL,
  `before_head` text DEFAULT NULL,
  `after_body` text DEFAULT NULL,
  `before_body` text DEFAULT NULL,
  `home_service_on_off` int(11) DEFAULT 1,
  `home_welcome_on_off` int(11) DEFAULT 1,
  `home_featured_product_on_off` int(11) DEFAULT 1,
  `home_latest_product_on_off` int(11) DEFAULT 1,
  `home_popular_product_on_off` int(11) DEFAULT 1,
  `home_testimonial_on_off` int(11) DEFAULT 1,
  `home_blog_on_off` int(11) DEFAULT 1,
  `newsletter_on_off` int(11) DEFAULT 1,
  `ads_above_welcome_on_off` int(1) DEFAULT 0,
  `ads_above_featured_product_on_off` int(1) DEFAULT 0,
  `ads_above_latest_product_on_off` int(1) DEFAULT 0,
  `ads_above_popular_product_on_off` int(1) DEFAULT 0,
  `ads_above_testimonial_on_off` int(1) DEFAULT 0,
  `ads_category_sidebar_on_off` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`id`, `logo`, `favicon`, `footer_about`, `footer_copyright`, `contact_address`, `contact_email`, `contact_phone`, `contact_fax`, `contact_map_iframe`, `receive_email`, `receive_email_subject`, `receive_email_thank_you_message`, `forget_password_message`, `total_recent_post_footer`, `total_popular_post_footer`, `total_recent_post_sidebar`, `total_popular_post_sidebar`, `total_featured_product_home`, `total_latest_product_home`, `total_popular_product_home`, `meta_title_home`, `meta_keyword_home`, `meta_description_home`, `banner_login`, `banner_registration`, `banner_forget_password`, `banner_reset_password`, `banner_search`, `banner_cart`, `banner_checkout`, `banner_product_category`, `banner_seller_login`, `banner_seller_registration`, `banner_blog`, `cta_title`, `cta_content`, `cta_read_more_text`, `cta_read_more_url`, `cta_photo`, `featured_product_title`, `featured_product_subtitle`, `latest_product_title`, `latest_product_subtitle`, `popular_product_title`, `popular_product_subtitle`, `testimonial_title`, `testimonial_subtitle`, `testimonial_photo`, `blog_title`, `blog_subtitle`, `newsletter_text`, `paypal_email`, `stripe_public_key`, `stripe_secret_key`, `bank_detail`, `before_head`, `after_body`, `before_body`, `home_service_on_off`, `home_welcome_on_off`, `home_featured_product_on_off`, `home_latest_product_on_off`, `home_popular_product_on_off`, `home_testimonial_on_off`, `home_blog_on_off`, `newsletter_on_off`, `ads_above_welcome_on_off`, `ads_above_featured_product_on_off`, `ads_above_latest_product_on_off`, `ads_above_popular_product_on_off`, `ads_above_testimonial_on_off`, `ads_category_sidebar_on_off`) VALUES
(1, 'logo.png', 'favicon.png', '<p>Lorem ipsum dolor sit amet, omnis signiferumque in mei, mei ex enim concludaturque. Senserit salutandi euripidis no per, modus maiestatis scribentur est an.Â Ea suas pertinax has.</p>\r\n', '© E-martz.com 2025 ', 'surat-gujrat \r\nindia ', 'emartz6976@gmail.com', '+91 97263 31300', '', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14875.252635074734!2d72.8384010692442!3d21.239256408835978!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04f6125e76b99%3A0xb7fdfaa0eba9a5c1!2sProf.V.B.Shah%20Institute%20of%20Management%20BBA%20Amroli%20College%20surat!5e0!3m2!1sen!2sin!4v1752936388595!5m2!1sen!2sin\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'emartz6976@gmail.com', 'Visitor Email Message from Ecommerce Site PHP', 'Thank you for sending email. We will contact you shortly.', 'A confirmation link is sent to your email address. You will get the password reset information in there.', 4, 4, 5, 5, 5, 5, 8, 'E-martz ', 'online fashion store, garments shop, online garments', 'ecommerce php project with mysql database', 'banner_login.jpg', 'banner_registration.jpg', 'banner_forget_password.jpg', 'banner_reset_password.jpg', 'banner_search.jpg', 'banner_cart.jpg', 'banner_checkout.jpg', 'banner_product_category.jpg', 'banner_seller_login.jpg', 'banner_seller_registration.jpg', 'banner_blog.jpg', 'Welcome To Our Ecommerce Website', 'Lorem ipsum dolor sit amet, an labores explicari qui, eu nostrum copiosae argumentum has. Latine propriae quo no, unum ridens expetenda id sit, \r\nat usu eius eligendi singulis. Sea ocurreret principes ne. At nonumy aperiri pri, nam quodsi copiosae intellegebat et, ex deserunt euripidis usu. ', 'Read More', '#', 'cta.jpg', 'Featured Products', 'Our list on Top Featured Products', 'Latest Products', 'Our list of recently added products', 'Popular Products', 'Popular products based on customer\'s choice', 'Testimonials', 'See what our clients tell about us', 'testimonial.jpg', 'Latest Blog', 'See all our latest articles and news from below', 'Sign-up to our newsletter for latest promotions and discounts.', '', 'pk_test_0SwMWadgu8DwmEcPdUPRsZ7b', 'sk_test_TFcsLJ7xxUtpALbDo1L5c1PN', 'Bank Name: WestView Bank\r\nAccount Number: CA100270589600\r\nBranch Name: CA Branch\r\nCountry: USA', '', '', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shipping_cost`
--

CREATE TABLE `tbl_shipping_cost` (
  `shipping_cost_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `amount` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_shipping_cost`
--

INSERT INTO `tbl_shipping_cost` (`shipping_cost_id`, `country_id`, `amount`) VALUES
(1, 228, '11'),
(2, 167, '10'),
(3, 13, '8'),
(4, 230, '0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shipping_cost_all`
--

CREATE TABLE `tbl_shipping_cost_all` (
  `sca_id` int(11) NOT NULL,
  `amount` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_shipping_cost_all`
--

INSERT INTO `tbl_shipping_cost_all` (`sca_id`, `amount`) VALUES
(1, '0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_size`
--

CREATE TABLE `tbl_size` (
  `size_id` int(11) NOT NULL,
  `size_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_size`
--

INSERT INTO `tbl_size` (`size_id`, `size_name`) VALUES
(1, 'XS'),
(2, 'S'),
(3, 'M'),
(4, 'L'),
(5, 'XL'),
(6, 'XXL'),
(7, 'XXXL'),
(26, 'Free Size');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_slider`
--

CREATE TABLE `tbl_slider` (
  `id` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `heading` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `button_text` varchar(255) NOT NULL,
  `button_url` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_slider`
--

INSERT INTO `tbl_slider` (`id`, `photo`, `heading`, `content`, `button_text`, `button_url`, `position`) VALUES
(1, 'slider-1.png', 'Welcome to our E-Martz', 'Shop Online for Latest Women Accessories', 'View Women Accessories', 'product-category.php?id=4&type=mid-category', 'Center'),
(2, 'slider-2.jpg', '50% Discount on All Products', 'Lorem ipsum dolor sit amet, an labores explicari qui, eu nostrum copiosae argumentum has.', 'Read More', '#', 'Center'),
(3, 'slider-3.png', '24 Hours Customer Support', 'Lorem ipsum dolor sit amet, an labores explicari qui, eu nostrum copiosae argumentum has.', 'Read More', '#', 'Right');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_social`
--

CREATE TABLE `tbl_social` (
  `social_id` int(11) NOT NULL,
  `social_name` varchar(30) NOT NULL,
  `social_url` varchar(255) NOT NULL,
  `social_icon` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_social`
--

INSERT INTO `tbl_social` (`social_id`, `social_name`, `social_url`, `social_icon`) VALUES
(1, 'Facebook', 'https://www.facebook.com/#', 'fa fa-facebook'),
(2, 'Twitter', 'https://www.twitter.com/#', 'fa fa-twitter'),
(3, 'LinkedIn', '', 'fa fa-linkedin'),
(4, 'Google Plus', '', 'fa fa-google-plus'),
(5, 'Pinterest', '', 'fa fa-pinterest'),
(6, 'YouTube', 'https://youtube.com/@e-martz?si=oHltt1viK20HbewJ', 'fa fa-youtube'),
(7, 'Instagram', 'https://www.instagram.com/emartz.in?igsh=a2hkcno1eXp4NW1o ', 'fa fa-instagram'),
(8, 'Tumblr', '', 'fa fa-tumblr'),
(9, 'Flickr', '', 'fa fa-flickr'),
(10, 'Reddit', '', 'fa fa-reddit'),
(11, 'Snapchat', '', 'fa fa-snapchat'),
(12, 'WhatsApp', 'https://whatsapp.com/channel/0029VbBBm0DI7Be7wi0dy138', 'fa fa-whatsapp'),
(13, 'Quora', '', 'fa fa-quora'),
(14, 'StumbleUpon', '', 'fa fa-stumbleupon'),
(15, 'Delicious', '', 'fa fa-delicious'),
(16, 'Digg', '', 'fa fa-digg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subscriber`
--

CREATE TABLE `tbl_subscriber` (
  `subs_id` int(11) NOT NULL,
  `subs_email` varchar(255) NOT NULL,
  `subs_date` varchar(100) NOT NULL,
  `subs_date_time` varchar(100) NOT NULL,
  `subs_hash` varchar(255) NOT NULL,
  `subs_active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_subscriber`
--

INSERT INTO `tbl_subscriber` (`subs_id`, `subs_email`, `subs_date`, `subs_date_time`, `subs_hash`, `subs_active`) VALUES
(11, 'chavdamehul105@gmail.com', '2025-07-30', '2025-07-30 04:51:10', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_top_category`
--

CREATE TABLE `tbl_top_category` (
  `tcat_id` int(11) NOT NULL,
  `tcat_name` varchar(255) NOT NULL,
  `show_on_menu` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_top_category`
--

INSERT INTO `tbl_top_category` (`tcat_id`, `tcat_name`, `show_on_menu`) VALUES
(1, 'Men', 1),
(2, 'Women', 1),
(3, 'Kids', 1),
(4, 'Electronics', 1),
(5, 'Health and Household', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(10) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `role` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `full_name`, `email`, `phone`, `password`, `photo`, `role`, `status`) VALUES
(1, 'Mehul', 'chavdamehul105@gmail.com', '9726331300', '$2y$10$lMTEtV5wPz7wDrOr2FRCO.sdal.vx40v1a3ySm21UOHypOosiJC9e', 'user-.png', 'Admin', 'Active'),
(2, 'Administrator', 'admin@mail.com', '9726331300', '$2y$10$Ci.IubJVeimwLHLxd9gYAO5StSKNIxH/iEclW01uitYsjUqBQlXm.', 'user-1.png', 'Super Admin', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_video`
--

CREATE TABLE `tbl_video` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `iframe_code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_video`
--

INSERT INTO `tbl_video` (`id`, `title`, `iframe_code`) VALUES
(1, 'Video 1', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/L3XAFSMdVWU\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>'),
(2, 'Video 2', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/sinQ06YzbJI\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>'),
(4, 'Video 3', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/ViZNgU-Yt-Y\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_wishlist`
--

CREATE TABLE `tbl_wishlist` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_wishlist`
--

INSERT INTO `tbl_wishlist` (`id`, `customer_id`, `product_id`, `created_at`) VALUES
(37, 11, 86, '2025-07-20 10:53:57'),
(39, 11, 97, '2025-07-20 11:00:28'),
(40, 11, 100, '2025-07-21 06:03:18'),
(42, 11, 95, '2025-07-21 06:28:11'),
(44, 11, 85, '2025-07-22 05:31:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tbl_color`
--
ALTER TABLE `tbl_color`
  ADD PRIMARY KEY (`color_id`);

--
-- Indexes for table `tbl_contact_messages`
--
ALTER TABLE `tbl_contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_country`
--
ALTER TABLE `tbl_country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `tbl_customer_message`
--
ALTER TABLE `tbl_customer_message`
  ADD PRIMARY KEY (`customer_message_id`);

--
-- Indexes for table `tbl_end_category`
--
ALTER TABLE `tbl_end_category`
  ADD PRIMARY KEY (`ecat_id`);

--
-- Indexes for table `tbl_faq`
--
ALTER TABLE `tbl_faq`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `tbl_language`
--
ALTER TABLE `tbl_language`
  ADD PRIMARY KEY (`lang_id`);

--
-- Indexes for table `tbl_mid_category`
--
ALTER TABLE `tbl_mid_category`
  ADD PRIMARY KEY (`mcat_id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_page`
--
ALTER TABLE `tbl_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`),
  ADD UNIQUE KEY `tracking_id` (`tracking_id`);

--
-- Indexes for table `tbl_photo`
--
ALTER TABLE `tbl_photo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_post`
--
ALTER TABLE `tbl_post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `tbl_product_color`
--
ALTER TABLE `tbl_product_color`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_product_photo`
--
ALTER TABLE `tbl_product_photo`
  ADD PRIMARY KEY (`pp_id`);

--
-- Indexes for table `tbl_product_size`
--
ALTER TABLE `tbl_product_size`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_rating`
--
ALTER TABLE `tbl_rating`
  ADD PRIMARY KEY (`rt_id`),
  ADD KEY `subject` (`subject`);

--
-- Indexes for table `tbl_service`
--
ALTER TABLE `tbl_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_shipping_cost`
--
ALTER TABLE `tbl_shipping_cost`
  ADD PRIMARY KEY (`shipping_cost_id`);

--
-- Indexes for table `tbl_shipping_cost_all`
--
ALTER TABLE `tbl_shipping_cost_all`
  ADD PRIMARY KEY (`sca_id`);

--
-- Indexes for table `tbl_size`
--
ALTER TABLE `tbl_size`
  ADD PRIMARY KEY (`size_id`);

--
-- Indexes for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_social`
--
ALTER TABLE `tbl_social`
  ADD PRIMARY KEY (`social_id`);

--
-- Indexes for table `tbl_subscriber`
--
ALTER TABLE `tbl_subscriber`
  ADD PRIMARY KEY (`subs_id`);

--
-- Indexes for table `tbl_top_category`
--
ALTER TABLE `tbl_top_category`
  ADD PRIMARY KEY (`tcat_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_video`
--
ALTER TABLE `tbl_video`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_wishlist`
--
ALTER TABLE `tbl_wishlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_wishlist` (`customer_id`,`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_color`
--
ALTER TABLE `tbl_color`
  MODIFY `color_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tbl_contact_messages`
--
ALTER TABLE `tbl_contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_country`
--
ALTER TABLE `tbl_country`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `cust_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_customer_message`
--
ALTER TABLE `tbl_customer_message`
  MODIFY `customer_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `tbl_end_category`
--
ALTER TABLE `tbl_end_category`
  MODIFY `ecat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `tbl_faq`
--
ALTER TABLE `tbl_faq`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_language`
--
ALTER TABLE `tbl_language`
  MODIFY `lang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `tbl_mid_category`
--
ALTER TABLE `tbl_mid_category`
  MODIFY `mcat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tbl_page`
--
ALTER TABLE `tbl_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `tbl_photo`
--
ALTER TABLE `tbl_photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_post`
--
ALTER TABLE `tbl_post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `tbl_product_color`
--
ALTER TABLE `tbl_product_color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=331;

--
-- AUTO_INCREMENT for table `tbl_product_photo`
--
ALTER TABLE `tbl_product_photo`
  MODIFY `pp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `tbl_product_size`
--
ALTER TABLE `tbl_product_size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=515;

--
-- AUTO_INCREMENT for table `tbl_rating`
--
ALTER TABLE `tbl_rating`
  MODIFY `rt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_service`
--
ALTER TABLE `tbl_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_shipping_cost`
--
ALTER TABLE `tbl_shipping_cost`
  MODIFY `shipping_cost_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_shipping_cost_all`
--
ALTER TABLE `tbl_shipping_cost_all`
  MODIFY `sca_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_size`
--
ALTER TABLE `tbl_size`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tbl_subscriber`
--
ALTER TABLE `tbl_subscriber`
  MODIFY `subs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_wishlist`
--
ALTER TABLE `tbl_wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
