-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2022 at 08:54 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fineoutput`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_cities`
--

CREATE TABLE `all_cities` (
  `id` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `state_id` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `all_cities`
--

INSERT INTO `all_cities` (`id`, `city_name`, `state_id`) VALUES
(1, 'Alipur', '1'),
(2, 'Andaman Island', '1'),
(3, 'Anderson Island', '1'),
(4, 'Arainj-Laka-Punga', '1'),
(5, 'Austinabad', '1'),
(6, 'Bamboo Flat', '1'),
(7, 'Barren Island', '1'),
(8, 'Beadonabad', '1'),
(9, 'Betapur', '1'),
(10, 'Bindraban', '1'),
(11, 'Bonington', '1'),
(12, 'Brookesabad', '1'),
(13, 'Cadell Point', '1'),
(14, 'Calicut', '1'),
(15, 'Chetamale', '1'),
(16, 'Cinque Islands', '1'),
(17, 'Defence Island', '1'),
(18, 'Digilpur', '1'),
(19, 'Dolyganj', '1'),
(20, 'Flat Island', '1'),
(21, 'Geinyale', '1'),
(22, 'Great Coco Island', '1'),
(23, 'Haddo', '1'),
(24, 'Havelock Island', '1'),
(25, 'Henry Lawrence Island', '1'),
(26, 'Herbertabad', '1'),
(27, 'Hobdaypur', '1'),
(28, 'Ilichar', '1'),
(29, 'Ingoie', '1'),
(30, 'Inteview Island', '1'),
(31, 'Jangli Ghat', '1'),
(32, 'Jhon Lawrence Island', '1'),
(33, 'Karen', '1'),
(34, 'Kartara', '1'),
(35, 'KYD Islannd', '1'),
(36, 'Landfall Island', '1'),
(37, 'Little Andmand', '1'),
(38, 'Little Coco Island', '1'),
(39, 'Long Island', '1'),
(40, 'Maimyo', '1'),
(41, 'Malappuram', '1'),
(42, 'Manglutan', '1'),
(43, 'Manpur', '1'),
(44, 'Mitha Khari', '1'),
(45, 'Neill Island', '1'),
(46, 'Nicobar Island', '1'),
(47, 'North Brother Island', '1'),
(48, 'North Passage Island', '1'),
(49, 'North Sentinel Island', '1'),
(50, 'Nothen Reef Island', '1'),
(51, 'Outram Island', '1'),
(52, 'Pahlagaon', '1'),
(53, 'Palalankwe', '1'),
(54, 'Passage Island', '1'),
(55, 'Phaiapong', '1'),
(56, 'Phoenix Island', '1'),
(57, 'Port Blair', '1'),
(58, 'Preparis Island', '1'),
(59, 'Protheroepur', '1'),
(60, 'Rangachang', '1'),
(61, 'Rongat', '1'),
(62, 'Rutland Island', '1'),
(63, 'Sabari', '1'),
(64, 'Saddle Peak', '1'),
(65, 'Shadipur', '1'),
(66, 'Smith Island', '1'),
(67, 'Sound Island', '1'),
(68, 'South Sentinel Island', '1'),
(69, 'Spike Island', '1'),
(70, 'Tarmugli Island', '1'),
(71, 'Taylerabad', '1'),
(72, 'Titaije', '1'),
(73, 'Toibalawe', '1'),
(74, 'Tusonabad', '1'),
(75, 'West Island', '1'),
(76, 'Wimberleyganj', '1'),
(77, 'Yadita', '1'),
(78, 'Adilabad', '2'),
(79, 'Anantapur', '2'),
(80, 'Chittoor', '2'),
(81, 'Cuddapah', '2'),
(82, 'East Godavari', '2'),
(83, 'Guntur', '2'),
(84, 'Hyderabad', '2'),
(85, 'Karimnagar', '2'),
(86, 'Khammam', '2'),
(87, 'Krishna', '2'),
(88, 'Kurnool', '2'),
(89, 'Mahabubnagar', '2'),
(90, 'Medak', '2'),
(91, 'Nalgonda', '2'),
(92, 'Nellore', '2'),
(93, 'Nizamabad', '2'),
(94, 'Prakasam', '2'),
(95, 'Rangareddy', '2'),
(96, 'Srikakulam', '2'),
(97, 'Visakhapatnam', '2'),
(98, 'Vizianagaram', '2'),
(99, 'Warangal', '2'),
(100, 'West Godavari', '2'),
(101, 'Anjaw', '3'),
(102, 'Changlang', '3'),
(103, 'Dibang Valley', '3'),
(104, 'East Kameng', '3'),
(105, 'East Siang', '3'),
(106, 'Itanagar', '3'),
(107, 'Kurung Kumey', '3'),
(108, 'Lohit', '3'),
(109, 'Lower Dibang Valley', '3'),
(110, 'Lower Subansiri', '3'),
(111, 'Papum Pare', '3'),
(112, 'Tawang', '3'),
(113, 'Tirap', '3'),
(114, 'Upper Siang', '3'),
(115, 'Upper Subansiri', '3'),
(116, 'West Kameng', '3'),
(117, 'West Siang', '3'),
(118, 'Barpeta', '4'),
(119, 'Bongaigaon', '4'),
(120, 'Cachar', '4'),
(121, 'Darrang', '4'),
(122, 'Dhemaji', '4'),
(123, 'Dhubri', '4'),
(124, 'Dibrugarh', '4'),
(125, 'Goalpara', '4'),
(126, 'Golaghat', '4'),
(127, 'Guwahati', '4'),
(128, 'Hailakandi', '4'),
(129, 'Jorhat', '4'),
(130, 'Kamrup', '4'),
(131, 'Karbi Anglong', '4'),
(132, 'Karimganj', '4'),
(133, 'Kokrajhar', '4'),
(134, 'Lakhimpur', '4'),
(135, 'Marigaon', '4'),
(136, 'Nagaon', '4'),
(137, 'Nalbari', '4'),
(138, 'North Cachar Hills', '4'),
(139, 'Silchar', '4'),
(140, 'Sivasagar', '4'),
(141, 'Sonitpur', '4'),
(142, 'Tinsukia', '4'),
(143, 'Udalguri', '4'),
(144, 'Araria', '5'),
(145, 'Aurangabad', '5'),
(146, 'Banka', '5'),
(147, 'Begusarai', '5'),
(148, 'Bhagalpur', '5'),
(149, 'Bhojpur', '5'),
(150, 'Buxar', '5'),
(151, 'Darbhanga', '5'),
(152, 'East Champaran', '5'),
(153, 'Gaya', '5'),
(154, 'Gopalganj', '5'),
(155, 'Jamshedpur', '5'),
(156, 'Jamui', '5'),
(157, 'Jehanabad', '5'),
(158, 'Kaimur (Bhabua)', '5'),
(159, 'Katihar', '5'),
(160, 'Khagaria', '5'),
(161, 'Kishanganj', '5'),
(162, 'Lakhisarai', '5'),
(163, 'Madhepura', '5'),
(164, 'Madhubani', '5'),
(165, 'Munger', '5'),
(166, 'Muzaffarpur', '5'),
(167, 'Nalanda', '5'),
(168, 'Nawada', '5'),
(169, 'Patna', '5'),
(170, 'Purnia', '5'),
(171, 'Rohtas', '5'),
(172, 'Saharsa', '5'),
(173, 'Samastipur', '5'),
(174, 'Saran', '5'),
(175, 'Sheikhpura', '5'),
(176, 'Sheohar', '5'),
(177, 'Sitamarhi', '5'),
(178, 'Siwan', '5'),
(179, 'Supaul', '5'),
(180, 'Vaishali', '5'),
(181, 'West Champaran', '5'),
(182, 'Chandigarh', '6'),
(183, 'Mani Marja', '6'),
(184, 'Bastar', '7'),
(185, 'Bhilai', '7'),
(186, 'Bijapur', '7'),
(187, 'Bilaspur', '7'),
(188, 'Dhamtari', '7'),
(189, 'Durg', '7'),
(190, 'Janjgir-Champa', '7'),
(191, 'Jashpur', '7'),
(192, 'Kabirdham-Kawardha', '7'),
(193, 'Korba', '7'),
(194, 'Korea', '7'),
(195, 'Mahasamund', '7'),
(196, 'Narayanpur', '7'),
(197, 'Norh Bastar-Kanker', '7'),
(198, 'Raigarh', '7'),
(199, 'Raipur', '7'),
(200, 'Rajnandgaon', '7'),
(201, 'South Bastar-Dantewada', '7'),
(202, 'Surguja', '7'),
(203, 'Amal', '8'),
(204, 'Amli', '8'),
(205, 'Bedpa', '8'),
(206, 'Chikhli', '8'),
(207, 'Dadra & Nagar Haveli', '8'),
(208, 'Dahikhed', '8'),
(209, 'Dolara', '8'),
(210, 'Galonda', '8'),
(211, 'Kanadi', '8'),
(212, 'Karchond', '8'),
(213, 'Khadoli', '8'),
(214, 'Kharadpada', '8'),
(215, 'Kherabari', '8'),
(216, 'Kherdi', '8'),
(217, 'Kothar', '8'),
(218, 'Luari', '8'),
(219, 'Mashat', '8'),
(220, 'Rakholi', '8'),
(221, 'Rudana', '8'),
(222, 'Saili', '8'),
(223, 'Sili', '8'),
(224, 'Silvassa', '8'),
(225, 'Sindavni', '8'),
(226, 'Udva', '8'),
(227, 'Umbarkoi', '8'),
(228, 'Vansda', '8'),
(229, 'Vasona', '8'),
(230, 'Velugam', '8'),
(231, 'Brancavare', '9'),
(232, 'Dagasi', '9'),
(233, 'Daman', '9'),
(234, 'Diu', '9'),
(235, 'Magarvara', '9'),
(236, 'Nagwa', '9'),
(237, 'Pariali', '9'),
(238, 'Passo Covo', '9'),
(239, 'Central Delhi', '10'),
(240, 'East Delhi', '10'),
(241, 'New Delhi', '10'),
(242, 'North Delhi', '10'),
(243, 'North East Delhi', '10'),
(244, 'North West Delhi', '10'),
(245, 'Old Delhi', '10'),
(246, 'South Delhi', '10'),
(247, 'South West Delhi', '10'),
(248, 'West Delhi', '10'),
(249, 'Canacona', '11'),
(250, 'Candolim', '11'),
(251, 'Chinchinim', '11'),
(252, 'Cortalim', '11'),
(253, 'Goa', '11'),
(254, 'Jua', '11'),
(255, 'Madgaon', '11'),
(256, 'Mahem', '11'),
(257, 'Mapuca', '11'),
(258, 'Marmagao', '11'),
(259, 'Panji', '11'),
(260, 'Ponda', '11'),
(261, 'Sanvordem', '11'),
(262, 'Terekhol', '11'),
(263, 'Ahmedabad', '12'),
(264, 'Amreli', '12'),
(265, 'Anand', '12'),
(266, 'Banaskantha', '12'),
(267, 'Baroda', '12'),
(268, 'Bharuch', '12'),
(269, 'Bhavnagar', '12'),
(270, 'Dahod', '12'),
(271, 'Dang', '12'),
(272, 'Dwarka', '12'),
(273, 'Gandhinagar', '12'),
(274, 'Jamnagar', '12'),
(275, 'Junagadh', '12'),
(276, 'Kheda', '12'),
(277, 'Kutch', '12'),
(278, 'Mehsana', '12'),
(279, 'Nadiad', '12'),
(280, 'Narmada', '12'),
(281, 'Navsari', '12'),
(282, 'Panchmahals', '12'),
(283, 'Patan', '12'),
(284, 'Porbandar', '12'),
(285, 'Rajkot', '12'),
(286, 'Sabarkantha', '12'),
(287, 'Surat', '12'),
(288, 'Surendranagar', '12'),
(289, 'Vadodara', '12'),
(290, 'Valsad', '12'),
(291, 'Vapi', '12'),
(292, 'Ambala', '13'),
(293, 'Bhiwani', '13'),
(294, 'Faridabad', '13'),
(295, 'Fatehabad', '13'),
(296, 'Gurgaon', '13'),
(297, 'Hisar', '13'),
(298, 'Jhajjar', '13'),
(299, 'Jind', '13'),
(300, 'Kaithal', '13'),
(301, 'Karnal', '13'),
(302, 'Kurukshetra', '13'),
(303, 'Mahendragarh', '13'),
(304, 'Mewat', '13'),
(305, 'Panchkula', '13'),
(306, 'Panipat', '13'),
(307, 'Rewari', '13'),
(308, 'Rohtak', '13'),
(309, 'Sirsa', '13'),
(310, 'Sonipat', '13'),
(311, 'Yamunanagar', '13'),
(312, 'Bilaspur', '14'),
(313, 'Chamba', '14'),
(314, 'Dalhousie', '14'),
(315, 'Hamirpur', '14'),
(316, 'Kangra', '14'),
(317, 'Kinnaur', '14'),
(318, 'Kullu', '14'),
(319, 'Lahaul & Spiti', '14'),
(320, 'Mandi', '14'),
(321, 'Shimla', '14'),
(322, 'Sirmaur', '14'),
(323, 'Solan', '14'),
(324, 'Una', '14'),
(325, 'Anantnag', '15'),
(326, 'Baramulla', '15'),
(327, 'Budgam', '15'),
(328, 'Doda', '15'),
(329, 'Jammu', '15'),
(330, 'Kargil', '15'),
(331, 'Kathua', '15'),
(332, 'Kupwara', '15'),
(333, 'Leh', '15'),
(334, 'Poonch', '15'),
(335, 'Pulwama', '15'),
(336, 'Rajauri', '15'),
(337, 'Srinagar', '15'),
(338, 'Udhampur', '15'),
(339, 'Bokaro', '16'),
(340, 'Chatra', '16'),
(341, 'Deoghar', '16'),
(342, 'Dhanbad', '16'),
(343, 'Dumka', '16'),
(344, 'East Singhbhum', '16'),
(345, 'Garhwa', '16'),
(346, 'Giridih', '16'),
(347, 'Godda', '16'),
(348, 'Gumla', '16'),
(349, 'Hazaribag', '16'),
(350, 'Jamtara', '16'),
(351, 'Koderma', '16'),
(352, 'Latehar', '16'),
(353, 'Lohardaga', '16'),
(354, 'Pakur', '16'),
(355, 'Palamu', '16'),
(356, 'Ranchi', '16'),
(357, 'Sahibganj', '16'),
(358, 'Seraikela', '16'),
(359, 'Simdega', '16'),
(360, 'West Singhbhum', '16'),
(361, 'Bagalkot', '17'),
(362, 'Bangalore', '17'),
(363, 'Bangalore Rural', '17'),
(364, 'Belgaum', '17'),
(365, 'Bellary', '17'),
(366, 'Bhatkal', '17'),
(367, 'Bidar', '17'),
(368, 'Bijapur', '17'),
(369, 'Chamrajnagar', '17'),
(370, 'Chickmagalur', '17'),
(371, 'Chikballapur', '17'),
(372, 'Chitradurga', '17'),
(373, 'Dakshina Kannada', '17'),
(374, 'Davanagere', '17'),
(375, 'Dharwad', '17'),
(376, 'Gadag', '17'),
(377, 'Gulbarga', '17'),
(378, 'Hampi', '17'),
(379, 'Hassan', '17'),
(380, 'Haveri', '17'),
(381, 'Hospet', '17'),
(382, 'Karwar', '17'),
(383, 'Kodagu', '17'),
(384, 'Kolar', '17'),
(385, 'Koppal', '17'),
(386, 'Madikeri', '17'),
(387, 'Mandya', '17'),
(388, 'Mangalore', '17'),
(389, 'Manipal', '17'),
(390, 'Mysore', '17'),
(391, 'Raichur', '17'),
(392, 'Shimoga', '17'),
(393, 'Sirsi', '17'),
(394, 'Sringeri', '17'),
(395, 'Srirangapatna', '17'),
(396, 'Tumkur', '17'),
(397, 'Udupi', '17'),
(398, 'Uttara Kannada', '17'),
(399, 'Alappuzha', '18'),
(400, 'Alleppey', '18'),
(401, 'Alwaye', '18'),
(402, 'Ernakulam', '18'),
(403, 'Idukki', '18'),
(404, 'Kannur', '18'),
(405, 'Kasargod', '18'),
(406, 'Kochi', '18'),
(407, 'Kollam', '18'),
(408, 'Kottayam', '18'),
(409, 'Kovalam', '18'),
(410, 'Kozhikode', '18'),
(411, 'Malappuram', '18'),
(412, 'Palakkad', '18'),
(413, 'Pathanamthitta', '18'),
(414, 'Perumbavoor', '18'),
(415, 'Thiruvananthapuram', '18'),
(416, 'Thrissur', '18'),
(417, 'Trichur', '18'),
(418, 'Trivandrum', '18'),
(419, 'Wayanad', '18'),
(420, 'Agatti Island', '19'),
(421, 'Bingaram Island', '19'),
(422, 'Bitra Island', '19'),
(423, 'Chetlat Island', '19'),
(424, 'Kadmat Island', '19'),
(425, 'Kalpeni Island', '19'),
(426, 'Kavaratti Island', '19'),
(427, 'Kiltan Island', '19'),
(428, 'Lakshadweep Sea', '19'),
(429, 'Minicoy Island', '19'),
(430, 'North Island', '19'),
(431, 'South Island', '19'),
(432, 'Anuppur', '20'),
(433, 'Ashoknagar', '20'),
(434, 'Balaghat', '20'),
(435, 'Barwani', '20'),
(436, 'Betul', '20'),
(437, 'Bhind', '20'),
(438, 'Bhopal', '20'),
(439, 'Burhanpur', '20'),
(440, 'Chhatarpur', '20'),
(441, 'Chhindwara', '20'),
(442, 'Damoh', '20'),
(443, 'Datia', '20'),
(444, 'Dewas', '20'),
(445, 'Dhar', '20'),
(446, 'Dindori', '20'),
(447, 'Guna', '20'),
(448, 'Gwalior', '20'),
(449, 'Harda', '20'),
(450, 'Hoshangabad', '20'),
(451, 'Indore', '20'),
(452, 'Jabalpur', '20'),
(453, 'Jagdalpur', '20'),
(454, 'Jhabua', '20'),
(455, 'Katni', '20'),
(456, 'Khandwa', '20'),
(457, 'Khargone', '20'),
(458, 'Mandla', '20'),
(459, 'Mandsaur', '20'),
(460, 'Morena', '20'),
(461, 'Narsinghpur', '20'),
(462, 'Neemuch', '20'),
(463, 'Panna', '20'),
(464, 'Raisen', '20'),
(465, 'Rajgarh', '20'),
(466, 'Ratlam', '20'),
(467, 'Rewa', '20'),
(468, 'Sagar', '20'),
(469, 'Satna', '20'),
(470, 'Sehore', '20'),
(471, 'Seoni', '20'),
(472, 'Shahdol', '20'),
(473, 'Shajapur', '20'),
(474, 'Sheopur', '20'),
(475, 'Shivpuri', '20'),
(476, 'Sidhi', '20'),
(477, 'Tikamgarh', '20'),
(478, 'Ujjain', '20'),
(479, 'Umaria', '20'),
(480, 'Vidisha', '20'),
(481, 'Ahmednagar', '21'),
(482, 'Akola', '21'),
(483, 'Amravati', '21'),
(484, 'Aurangabad', '21'),
(485, 'Beed', '21'),
(486, 'Bhandara', '21'),
(487, 'Buldhana', '21'),
(488, 'Chandrapur', '21'),
(489, 'Dhule', '21'),
(490, 'Gadchiroli', '21'),
(491, 'Gondia', '21'),
(492, 'Hingoli', '21'),
(493, 'Jalgaon', '21'),
(494, 'Jalna', '21'),
(495, 'Kolhapur', '21'),
(496, 'Latur', '21'),
(497, 'Mahabaleshwar', '21'),
(498, 'Mumbai', '21'),
(499, 'Mumbai City', '21'),
(500, 'Mumbai Suburban', '21'),
(501, 'Nagpur', '21'),
(502, 'Nanded', '21'),
(503, 'Nandurbar', '21'),
(504, 'Nashik', '21'),
(505, 'Osmanabad', '21'),
(506, 'Parbhani', '21'),
(507, 'Pune', '21'),
(508, 'Raigad', '21'),
(509, 'Ratnagiri', '21'),
(510, 'Sangli', '21'),
(511, 'Satara', '21'),
(512, 'Sholapur', '21'),
(513, 'Sindhudurg', '21'),
(514, 'Thane', '21'),
(515, 'Wardha', '21'),
(516, 'Washim', '21'),
(517, 'Yavatmal', '21'),
(518, 'Bishnupur', '22'),
(519, 'Chandel', '22'),
(520, 'Churachandpur', '22'),
(521, 'Imphal East', '22'),
(522, 'Imphal West', '22'),
(523, 'Senapati', '22'),
(524, 'Tamenglong', '22'),
(525, 'Thoubal', '22'),
(526, 'Ukhrul', '22'),
(527, 'East Garo Hills', '23'),
(528, 'East Khasi Hills', '23'),
(529, 'Jaintia Hills', '23'),
(530, 'Ri Bhoi', '23'),
(531, 'Shillong', '23'),
(532, 'South Garo Hills', '23'),
(533, 'West Garo Hills', '23'),
(534, 'West Khasi Hills', '23'),
(535, 'Aizawl', '24'),
(536, 'Champhai', '24'),
(537, 'Kolasib', '24'),
(538, 'Lawngtlai', '24'),
(539, 'Lunglei', '24'),
(540, 'Mamit', '24'),
(541, 'Saiha', '24'),
(542, 'Serchhip', '24'),
(543, 'Dimapur', '25'),
(544, 'Kohima', '25'),
(545, 'Mokokchung', '25'),
(546, 'Mon', '25'),
(547, 'Phek', '25'),
(548, 'Tuensang', '25'),
(549, 'Wokha', '25'),
(550, 'Zunheboto', '25'),
(551, 'Angul', '26'),
(552, 'Balangir', '26'),
(553, 'Balasore', '26'),
(554, 'Baleswar', '26'),
(555, 'Bargarh', '26'),
(556, 'Berhampur', '26'),
(557, 'Bhadrak', '26'),
(558, 'Bhubaneswar', '26'),
(559, 'Boudh', '26'),
(560, 'Cuttack', '26'),
(561, 'Deogarh', '26'),
(562, 'Dhenkanal', '26'),
(563, 'Gajapati', '26'),
(564, 'Ganjam', '26'),
(565, 'Jagatsinghapur', '26'),
(566, 'Jajpur', '26'),
(567, 'Jharsuguda', '26'),
(568, 'Kalahandi', '26'),
(569, 'Kandhamal', '26'),
(570, 'Kendrapara', '26'),
(571, 'Kendujhar', '26'),
(572, 'Khordha', '26'),
(573, 'Koraput', '26'),
(574, 'Malkangiri', '26'),
(575, 'Mayurbhanj', '26'),
(576, 'Nabarangapur', '26'),
(577, 'Nayagarh', '26'),
(578, 'Nuapada', '26'),
(579, 'Puri', '26'),
(580, 'Rayagada', '26'),
(581, 'Rourkela', '26'),
(582, 'Sambalpur', '26'),
(583, 'Subarnapur', '26'),
(584, 'Sundergarh', '26'),
(585, 'Bahur', '27'),
(586, 'Karaikal', '27'),
(587, 'Mahe', '27'),
(588, 'Pondicherry', '27'),
(589, 'Purnankuppam', '27'),
(590, 'Valudavur', '27'),
(591, 'Villianur', '27'),
(592, 'Yanam', '27'),
(593, 'Amritsar', '28'),
(594, 'Barnala', '28'),
(595, 'Bathinda', '28'),
(596, 'Faridkot', '28'),
(597, 'Fatehgarh Sahib', '28'),
(598, 'Ferozepur', '28'),
(599, 'Gurdaspur', '28'),
(600, 'Hoshiarpur', '28'),
(601, 'Jalandhar', '28'),
(602, 'Kapurthala', '28'),
(603, 'Ludhiana', '28'),
(604, 'Mansa', '28'),
(605, 'Moga', '28'),
(606, 'Muktsar', '28'),
(607, 'Nawanshahr', '28'),
(608, 'Pathankot', '28'),
(609, 'Patiala', '28'),
(610, 'Rupnagar', '28'),
(611, 'Sangrur', '28'),
(612, 'SAS Nagar', '28'),
(613, 'Tarn Taran', '28'),
(614, 'Ajmer', '29'),
(615, 'Alwar', '29'),
(616, 'Banswara', '29'),
(617, 'Baran', '29'),
(618, 'Barmer', '29'),
(619, 'Bharatpur', '29'),
(620, 'Bhilwara', '29'),
(621, 'Bikaner', '29'),
(622, 'Bundi', '29'),
(623, 'Chittorgarh', '29'),
(624, 'Churu', '29'),
(625, 'Dausa', '29'),
(626, 'Dholpur', '29'),
(627, 'Dungarpur', '29'),
(628, 'Hanumangarh', '29'),
(629, 'Jaipur', '29'),
(630, 'Jaisalmer', '29'),
(631, 'Jalore', '29'),
(632, 'Jhalawar', '29'),
(633, 'Jhunjhunu', '29'),
(634, 'Jodhpur', '29'),
(635, 'Karauli', '29'),
(636, 'Kota', '29'),
(637, 'Nagaur', '29'),
(638, 'Pali', '29'),
(639, 'Pratapgarh', '29'),
(640, 'Rajsamand', '29'),
(641, 'Sawai Madhopur', '29'),
(642, 'Sikar', '29'),
(643, 'Sirohi', '29'),
(644, 'Sri Ganganagar', '29'),
(645, 'Tonk', '29'),
(646, 'Udaipur', '29'),
(647, 'Barmiak', '30'),
(648, 'Be', '30'),
(649, 'Bhurtuk', '30'),
(650, 'Chhubakha', '30'),
(651, 'Chidam', '30'),
(652, 'Chubha', '30'),
(653, 'Chumikteng', '30'),
(654, 'Dentam', '30'),
(655, 'Dikchu', '30'),
(656, 'Dzongri', '30'),
(657, 'Gangtok', '30'),
(658, 'Gauzing', '30'),
(659, 'Gyalshing', '30'),
(660, 'Hema', '30'),
(661, 'Kerung', '30'),
(662, 'Lachen', '30'),
(663, 'Lachung', '30'),
(664, 'Lema', '30'),
(665, 'Lingtam', '30'),
(666, 'Lungthu', '30'),
(667, 'Mangan', '30'),
(668, 'Namchi', '30'),
(669, 'Namthang', '30'),
(670, 'Nanga', '30'),
(671, 'Nantang', '30'),
(672, 'Naya Bazar', '30'),
(673, 'Padamachen', '30'),
(674, 'Pakhyong', '30'),
(675, 'Pemayangtse', '30'),
(676, 'Phensang', '30'),
(677, 'Rangli', '30'),
(678, 'Rinchingpong', '30'),
(679, 'Sakyong', '30'),
(680, 'Samdong', '30'),
(681, 'Singtam', '30'),
(682, 'Siniolchu', '30'),
(683, 'Sombari', '30'),
(684, 'Soreng', '30'),
(685, 'Sosing', '30'),
(686, 'Tekhug', '30'),
(687, 'Temi', '30'),
(688, 'Tsetang', '30'),
(689, 'Tsomgo', '30'),
(690, 'Tumlong', '30'),
(691, 'Yangang', '30'),
(692, 'Yumtang', '30'),
(693, 'Chennai', '31'),
(694, 'Chidambaram', '31'),
(695, 'Chingleput', '31'),
(696, 'Coimbatore', '31'),
(697, 'Courtallam', '31'),
(698, 'Cuddalore', '31'),
(699, 'Dharmapuri', '31'),
(700, 'Dindigul', '31'),
(701, 'Erode', '31'),
(702, 'Hosur', '31'),
(703, 'Kanchipuram', '31'),
(704, 'Kanyakumari', '31'),
(705, 'Karaikudi', '31'),
(706, 'Karur', '31'),
(707, 'Kodaikanal', '31'),
(708, 'Kovilpatti', '31'),
(709, 'Krishnagiri', '31'),
(710, 'Kumbakonam', '31'),
(711, 'Madurai', '31'),
(712, 'Mayiladuthurai', '31'),
(713, 'Nagapattinam', '31'),
(714, 'Nagarcoil', '31'),
(715, 'Namakkal', '31'),
(716, 'Neyveli', '31'),
(717, 'Nilgiris', '31'),
(718, 'Ooty', '31'),
(719, 'Palani', '31'),
(720, 'Perambalur', '31'),
(721, 'Pollachi', '31'),
(722, 'Pudukkottai', '31'),
(723, 'Rajapalayam', '31'),
(724, 'Ramanathapuram', '31'),
(725, 'Salem', '31'),
(726, 'Sivaganga', '31'),
(727, 'Sivakasi', '31'),
(728, 'Thanjavur', '31'),
(729, 'Theni', '31'),
(730, 'Thoothukudi', '31'),
(731, 'Tiruchirappalli', '31'),
(732, 'Tirunelveli', '31'),
(733, 'Tirupur', '31'),
(734, 'Tiruvallur', '31'),
(735, 'Tiruvannamalai', '31'),
(736, 'Tiruvarur', '31'),
(737, 'Trichy', '31'),
(738, 'Tuticorin', '31'),
(739, 'Vellore', '31'),
(740, 'Villupuram', '31'),
(741, 'Virudhunagar', '31'),
(742, 'Yercaud', '31'),
(743, 'Agartala', '32'),
(744, 'Ambasa', '32'),
(745, 'Bampurbari', '32'),
(746, 'Belonia', '32'),
(747, 'Dhalai', '32'),
(748, 'Dharam Nagar', '32'),
(749, 'Kailashahar', '32'),
(750, 'Kamal Krishnabari', '32'),
(751, 'Khopaiyapara', '32'),
(752, 'Khowai', '32'),
(753, 'Phuldungsei', '32'),
(754, 'Radha Kishore Pur', '32'),
(755, 'Tripura', '32'),
(756, 'Rohini', '29'),
(757, 'Rohini', '10'),
(758, 'Delhi', '10'),
(759, 'Howrah', '35'),
(760, 'Sarna Doongar', '29'),
(761, 'Bangalore', '17'),
(762, 'Bangaluru', '17'),
(763, 'Lucknow', '33'),
(764, 'Kanpur', '33'),
(765, 'Ghaziabad', '33'),
(766, 'Agra', '33'),
(767, 'Meerut', '33'),
(768, 'Varanasi', '33'),
(769, 'Allahabad', '33'),
(770, 'Bareilly', '33'),
(771, 'Aligarh', '33'),
(772, 'Moradabad', '33'),
(773, 'Saharanpur', '33'),
(774, 'Gorakhpur', '33'),
(775, 'Faizabad', '33'),
(776, 'Firozabad', '34'),
(777, 'Jhansi', '33'),
(778, 'Muzaffarnagar', '33'),
(779, 'Mathura-Veindavan', '33'),
(780, 'Budaun', '33'),
(781, 'Rampur', '33'),
(782, 'Shahjahanpur', '33'),
(783, 'Farrukhabad', '33'),
(784, 'Ayodhya cantt', '33'),
(785, 'MAU', '33'),
(786, 'Hapur', '33'),
(787, 'Noida', '33'),
(788, 'Etawah', '33'),
(789, 'Mirzapur', '33'),
(790, 'Bulandshahr', '33'),
(791, 'sambhal', '33'),
(792, 'Amraha', '33'),
(793, 'Hardoi', '33'),
(794, 'Fatehpur', '33'),
(795, 'Raebareli', '33'),
(796, 'Orai', '33'),
(797, 'Sitapur', '33'),
(798, 'Bahraich', '33'),
(799, 'Modinagar', '33'),
(800, 'Unnao', '33'),
(801, 'Jaunpur', '33'),
(802, 'Lakhimpur', '33'),
(803, 'Hathras', '33'),
(804, 'Banda', '33'),
(805, 'Pilibhit', '33'),
(806, 'Mughalsarai', '33'),
(807, 'Barabanki', '33'),
(808, 'Khurja', '33'),
(809, 'Gonda', '33'),
(810, 'Mainpuri', '33'),
(811, 'Lalitpur', '33'),
(812, 'Lalitpur', '33'),
(813, 'Etah', '33'),
(814, 'Deoria', '33'),
(815, 'ujhani', '33'),
(816, 'Ghazipur', '33'),
(817, 'Sultanpur', '33'),
(818, 'Azamgarh', '33'),
(819, 'Bijnor', '33'),
(820, 'Sahaswan', '33'),
(821, 'Basti', '33'),
(822, 'Chandausi', '33'),
(823, 'Akbarpur', '33'),
(824, 'Ballia', '33'),
(825, 'Tanda', '33'),
(826, 'Greater Noida', '33'),
(827, 'Shikohabad', '33'),
(828, 'Shamli', '33'),
(829, 'Awagarh', '33'),
(830, 'Kasganj', '33'),
(831, 'Maunath Bhanjan', '33'),
(832, 'Amroha', '33'),
(833, 'Fir', '33'),
(834, 'Firozabad', '33'),
(835, 'Jammu Tawi', '15');

-- --------------------------------------------------------

--
-- Table structure for table `all_states`
--

CREATE TABLE `all_states` (
  `id` int(11) NOT NULL,
  `state_name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `all_states`
--

INSERT INTO `all_states` (`id`, `state_name`) VALUES
(1, 'Andaman & Nicobar [AN]'),
(2, 'Andhra Pradesh [AP]'),
(3, 'Arunachal Pradesh [AR]'),
(4, 'Assam [AS]'),
(5, 'Bihar [BH]'),
(6, 'Chandigarh [CH]'),
(7, 'Chhattisgarh [CG]'),
(8, 'Dadra & Nagar Haveli [DN]'),
(9, 'Daman & Diu [DD]'),
(10, 'Delhi [DL]'),
(11, 'Goa [GO]'),
(12, 'Gujarat [GU]'),
(13, 'Haryana [HR]'),
(14, 'Himachal Pradesh [HP]'),
(15, 'Jammu & Kashmir [JK]'),
(16, 'Jharkhand [JH]'),
(17, 'Karnataka [KR]'),
(18, 'Kerala [KL]'),
(19, 'Lakshadweep [LD]'),
(20, 'Madhya Pradesh [MP]'),
(21, 'Maharashtra [MH]'),
(22, 'Manipur [MN]'),
(23, 'Meghalaya [ML]'),
(24, 'Mizoram [MM]'),
(25, 'Nagaland [NL]'),
(26, 'Orissa [OR]'),
(27, 'Pondicherry [PC]'),
(28, 'Punjab [PJ]'),
(29, 'Rajasthan [RJ]'),
(30, 'Sikkim [SK]'),
(31, 'Tamil Nadu [TN]'),
(32, 'Tripura [TR]'),
(33, 'Uttar Pradesh [UP]'),
(34, 'Uttaranchal [UT]'),
(35, 'West Bengal [WB]');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_sidebar`
--

CREATE TABLE `tbl_admin_sidebar` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `url` varchar(2000) NOT NULL,
  `sequence` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admin_sidebar`
--

INSERT INTO `tbl_admin_sidebar` (`id`, `name`, `url`, `sequence`) VALUES
(1, 'Dashboard', 'Home', 1),
(2, 'Team', 'System/view_team', 2),
(5, 'Slider', 'Slider/view_slider', 9),
(6, 'Products', 'Products/view_product_categories', 3),
(12, 'Orders', '#', 6),
(13, 'Category', 'Category/view_category', 4),
(14, 'Sub-Category', 'Subcategory/view_subcategory', 5),
(33, 'Promocode', 'Promocode/view_promocode', 22);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_sidebar2`
--

CREATE TABLE `tbl_admin_sidebar2` (
  `id` int(11) NOT NULL,
  `main_id` int(11) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `url` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admin_sidebar2`
--

INSERT INTO `tbl_admin_sidebar2` (`id`, `main_id`, `name`, `url`) VALUES
(1, 2, 'View Team', 'System/view_team'),
(2, 2, 'Add Team', 'System/add_team'),
(3, 12, 'New Orders', 'Orders/view_new_orders'),
(4, 12, 'Accepted Orders', 'Orders/view_accept_orders'),
(6, 12, 'Delivered Orders', 'Orders/view_completed_orders'),
(7, 12, 'Rejected Orders', 'Orders/view_rejected_orders'),
(8, 12, 'Cancelled Orders', 'Orders/view_cancelled_orders'),
(9, 12, 'Dispatched Orders', 'Orders/view_dispatched_orders'),
(10, 12, 'Test', 'Test/view_test');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `token_id` varchar(100) NOT NULL,
  `ip` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `image` text NOT NULL,
  `date` varchar(100) NOT NULL,
  `is_active` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `image2` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `category`, `image`, `date`, `is_active`, `added_by`, `image2`) VALUES
(1, 'One', 'assets/uploads/category/category220220615110640.jpeg', '2022-06-15 11:12:40', 1, 19, 'assets/uploads/category/category20220615110640.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contactus`
--

CREATE TABLE `tbl_contactus` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `message` varchar(300) NOT NULL,
  `date` varchar(100) NOT NULL,
  `is_active` int(11) NOT NULL,
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order1`
--

CREATE TABLE `tbl_order1` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `promocode_id` varchar(255) DEFAULT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `total_amount` int(11) DEFAULT NULL,
  `payment_type` int(11) DEFAULT NULL COMMENT '1 for Bank transfer , 2 for Pay on store',
  `bank_receipt` varchar(255) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `payment_status` int(11) DEFAULT NULL COMMENT '0 for pending , 1 for succeed',
  `order_status` int(11) DEFAULT NULL COMMENT '1 for orderPlaced , 2 for orderConfirmed , 3 for orderDispatched , 4 for orderDelivered , 5 for cancel,6 for hold',
  `final_amount` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `house_no` varchar(255) DEFAULT NULL,
  `street_address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `txnid` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `date` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order2`
--

CREATE TABLE `tbl_order2` (
  `id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `product_mrp` varchar(255) NOT NULL,
  `total_amount` varchar(255) DEFAULT NULL,
  `main_id` varchar(100) NOT NULL,
  `gst` varchar(255) DEFAULT NULL,
  `gst_percentage` varchar(255) DEFAULT NULL,
  `ip` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `id` int(11) NOT NULL,
  `productname` varchar(250) NOT NULL,
  `category_id` varchar(100) DEFAULT NULL,
  `subcategory_id` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `mrp` varchar(100) DEFAULT NULL,
  `sellingprice` varchar(50) NOT NULL,
  `gstprice` int(11) NOT NULL,
  `gstrate` varchar(255) DEFAULT NULL,
  `sellingpricegst` int(11) NOT NULL,
  `productdescription` text DEFAULT NULL,
  `inventory` varchar(250) NOT NULL,
  `feature_product` varchar(100) NOT NULL,
  `popular_product` int(100) NOT NULL,
  `added_by` int(11) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_promocode`
--

CREATE TABLE `tbl_promocode` (
  `id` int(11) NOT NULL,
  `promocode` varchar(255) NOT NULL,
  `ptype` varchar(244) NOT NULL,
  `giftpercent` varchar(255) NOT NULL,
  `minorder` varchar(255) NOT NULL,
  `max` varchar(255) NOT NULL,
  `expiry` varchar(255) NOT NULL,
  `ip` varchar(300) NOT NULL,
  `added_by` varchar(1111) NOT NULL,
  `is_active` varchar(200) NOT NULL,
  `date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_promocode`
--

INSERT INTO `tbl_promocode` (`id`, `promocode`, `ptype`, `giftpercent`, `minorder`, `max`, `expiry`, `ip`, `added_by`, `is_active`, `date`) VALUES
(1, 'WELL20', 'first time', '20', '200', '1000', '2022-06-23', '::1', '19', '1', '2022-06-15 11:56:45');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_slider`
--

CREATE TABLE `tbl_slider` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `added_by` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `is_active` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_slider`
--

INSERT INTO `tbl_slider` (`id`, `image`, `added_by`, `date`, `ip`, `is_active`) VALUES
(5, 'assets/uploads/Slider/Slider_image20220509100518.png', '19', '2022-05-09 09:44:15', '::1', '1'),
(7, 'assets/uploads/Slider/Slider_image20220509100524.png', '19', '2022-05-09 10:09:24', '::1', '1'),
(8, 'assets/uploads/Slider/Slider_image20220509100529.jpg', '19', '2022-05-09 10:35:01', '::1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subcategory`
--

CREATE TABLE `tbl_subcategory` (
  `id` int(11) NOT NULL,
  `category_id` varchar(100) DEFAULT NULL,
  `subcategory` varchar(100) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_team`
--

CREATE TABLE `tbl_team` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(500) NOT NULL,
  `password` varchar(2000) NOT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `address` varchar(2000) DEFAULT NULL,
  `image` varchar(1000) DEFAULT NULL,
  `power` int(11) NOT NULL,
  `services` varchar(1000) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `added_by` int(11) NOT NULL,
  `is_active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_team`
--

INSERT INTO `tbl_team` (`id`, `name`, `email`, `password`, `phone`, `address`, `image`, `power`, `services`, `ip`, `date`, `added_by`, `is_active`) VALUES
(1, 'Anay Pareek', 'anaypareek@rocketmail.com', '9ffd3dfaf18c6c0dededaba5d7db9375', '9799655891', '19 kalyanpuri new sanganer road sodala', '', 1, '[\"999\"]', '1000000', '16-05-2018', 1, 1),
(19, 'Demo', 'demo@gmail.com', 'f702c1502be8e55f4208d69419f50d0a', '9999999999', 'jaipur', NULL, 1, '[\"999\"]', '::1', '2020-01-04 18:12:55', 1, 1),
(29, 'Animesh Sharma', 'animesh.skyline@gmail.com', '8bda6fe26dad2b31f9cb9180ec3823e8', '8441849182', 'pratap nagar sitapura jaipur', '', 2, '[\"999\"]', '::1', '2020-01-06 14:47:11', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_wishlist`
--

CREATE TABLE `tbl_wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_wishlist`
--

INSERT INTO `tbl_wishlist` (`id`, `user_id`, `product_id`, `ip`, `date`) VALUES
(1, 1, 3, '49.204.165.132', '2022-04-02 18:48:31'),
(4, 11, 2, '49.204.164.140', '2022-05-20 17:24:48'),
(7, 1, 2, '49.204.164.140', '2022-05-21 11:57:14'),
(9, 16, 17, '49.204.165.199', '2022-05-25 16:18:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `all_cities`
--
ALTER TABLE `all_cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `all_states`
--
ALTER TABLE `all_states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin_sidebar`
--
ALTER TABLE `tbl_admin_sidebar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin_sidebar2`
--
ALTER TABLE `tbl_admin_sidebar2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_contactus`
--
ALTER TABLE `tbl_contactus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order1`
--
ALTER TABLE `tbl_order1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order2`
--
ALTER TABLE `tbl_order2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_promocode`
--
ALTER TABLE `tbl_promocode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_subcategory`
--
ALTER TABLE `tbl_subcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_team`
--
ALTER TABLE `tbl_team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_wishlist`
--
ALTER TABLE `tbl_wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `all_cities`
--
ALTER TABLE `all_cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=836;

--
-- AUTO_INCREMENT for table `all_states`
--
ALTER TABLE `all_states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbl_admin_sidebar`
--
ALTER TABLE `tbl_admin_sidebar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tbl_admin_sidebar2`
--
ALTER TABLE `tbl_admin_sidebar2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_contactus`
--
ALTER TABLE `tbl_contactus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_order1`
--
ALTER TABLE `tbl_order1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_order2`
--
ALTER TABLE `tbl_order2`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_promocode`
--
ALTER TABLE `tbl_promocode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_subcategory`
--
ALTER TABLE `tbl_subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_team`
--
ALTER TABLE `tbl_team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_wishlist`
--
ALTER TABLE `tbl_wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
