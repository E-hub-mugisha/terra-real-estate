-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 29, 2026 at 05:53 PM
-- Server version: 5.7.44-cll-lve
-- PHP Version: 8.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `terra_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `advertisements`
--

CREATE TABLE `advertisements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `advertisable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `advertisable_id` bigint(20) UNSIGNED NOT NULL,
  `ad_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `banner_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('pending','active','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agent_level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total_referrals` int(11) NOT NULL DEFAULT '0',
  `total_revenue_generated` decimal(14,2) NOT NULL DEFAULT '0.00',
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `linkedin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `office_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `languages` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `agent_level_id`, `total_referrals`, `total_revenue_generated`, `user_id`, `full_name`, `email`, `phone`, `bio`, `linkedin`, `facebook`, `instagram`, `twitter`, `profile_image`, `whatsapp`, `office_location`, `languages`, `is_verified`, `created_at`, `updated_at`) VALUES
(26, NULL, 0, 0.00, 89, 'KAYONGA Erasme', 'erasmus1030@gmail.com', '0788426229', 'Kayonga Erasme is an experienced surveying specialist with over 7 years of hands-on expertise in land measurement, boundary demarcation, and geospatial data analysis. He is known for delivering accurate, reliable, and timely surveying services, supporting clients in making informed real estate decisions. His commitment to precision and professionalism makes him a trusted expert in the field.', NULL, NULL, NULL, NULL, '1774521446_69c50c66c24ce.jpeg', '0788426229', 'Rwamagana, Muhazi', 'Kinyarwanda, English', 1, '2026-03-26 08:37:27', '2026-03-26 10:29:56'),
(27, NULL, 0, 0.00, 90, 'DUFITUMUKIZA Chadrack', 'dufitumukizachadrack@gmail.com', '0789695317', 'DUFITUMUKIZA Chadrack is a dedicated surveying professional with 2 years of experience in land measurement, boundary identification, and mapping services. He is committed to delivering accurate and dependable results, helping clients navigate real estate processes with confidence. His attention to detail and growing expertise make him a reliable asset in surveying services.', NULL, NULL, NULL, NULL, '1774525233_69c51b3115d55.jpeg', '0789695317', 'MUSANZE, KIMONYI', 'Kinyrwanda,English', 1, '2026-03-26 09:00:07', '2026-03-26 10:26:13'),
(29, NULL, 0, 0.00, 92, 'IYAKAREMYE Pascal', 'pascaliyakaremye6@gmail.com', '0783215819', 'IYAKAREMYE Pascal is a highly experienced surveying specialist with over 8 years of expertise in land measurement, boundary demarcation, and geospatial mapping. He is recognized for his precision, reliability, and deep understanding of surveying standards, helping clients make confident and informed real estate decisions. His professionalism and consistent delivery of high-quality results make him a trusted expert in the field.', NULL, NULL, NULL, NULL, '1774525047_69c51a770b6aa.jpeg', '0783215819', 'RUSIZI, KAMASHANGI', 'Kinyarwanda, English', 1, '2026-03-26 09:10:31', '2026-03-26 10:25:41'),
(33, NULL, 0, 0.00, 96, 'IRADUKUNDA delphine', 'delphineiradukunda853@gmail.com', '0783142221', 'Delphine Iradukunda is a Terra Real Estate Agent based in Kiyovu, Nyarugenge (Kigali), with an office at Mateus. She has extensive experience as a Banking Agent (Equity, BK, BPR, Irembo), which enables her to assist clients reliably and efficiently in all matters related to real estate.', NULL, NULL, NULL, NULL, '1774610446_69c6680eca693.png', '0783142221', 'Nyarugenge, Kiyovu', 'Kinyrwanda,English', 1, '2026-03-26 11:37:06', '2026-03-27 09:20:46'),
(36, NULL, 0, 0.00, 100, 'HABIYAREMYE Bertin', 'habiyaremyebertin6@gmail.com', '0788950103', 'Bertin HABIYAREMYE is a dedicated Terra Real Estate Agent based in Muhanga, with over 6 years of experience in land valuation, surveying, and architecture. Operating from his office in Nyamabuye Sector, Gahogo Cell (Nyarucyamo Village), he provides reliable and professional services to clients seeking accurate property insights and development support.', NULL, NULL, NULL, NULL, '1774610907_69c669db3dac0.jpeg', '0788950103', 'Muhanga, Nyamabuye', 'Kinyrwanda,English', 1, '2026-03-27 09:28:27', '2026-03-27 09:28:27');

-- --------------------------------------------------------

--
-- Table structure for table `agent_appointments`
--

CREATE TABLE `agent_appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agent_commissions`
--

CREATE TABLE `agent_commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `commissionable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commissionable_id` bigint(20) UNSIGNED DEFAULT NULL,
  `property_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `property_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `listing_package_id` bigint(20) UNSIGNED DEFAULT NULL,
  `listing_days` int(11) NOT NULL DEFAULT '0',
  `price_per_day` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount_applied_pct` decimal(5,2) NOT NULL DEFAULT '0.00',
  `listing_fee_gross` decimal(12,2) NOT NULL DEFAULT '0.00',
  `listing_fee_net` decimal(12,2) NOT NULL DEFAULT '0.00',
  `listing_agent_pct` decimal(5,2) NOT NULL DEFAULT '0.00',
  `listing_commission` decimal(12,2) NOT NULL DEFAULT '0.00',
  `sale_price` decimal(14,2) NOT NULL DEFAULT '0.00',
  `agent_level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sale_commission_rate` decimal(5,2) NOT NULL DEFAULT '0.00',
  `sale_commission` decimal(14,2) NOT NULL DEFAULT '0.00',
  `listing_commission_status` enum('pending','paid','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `sale_commission_status` enum('pending','approved','paid','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `listing_commission_paid_at` date DEFAULT NULL,
  `sale_commission_paid_at` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agent_levels`
--

CREATE TABLE `agent_levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `level_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `badge_emoji` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `badge_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commission_rate` decimal(5,2) NOT NULL,
  `requirements` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agent_levels`
--

INSERT INTO `agent_levels` (`id`, `level_name`, `label`, `badge_emoji`, `badge_color`, `commission_rate`, `requirements`, `created_at`, `updated_at`) VALUES
(1, 'bronze', 'Bronze Agent', '🥉', '#cd7f32', 25.00, 'Entry level. All new agents start here.', NULL, NULL),
(2, 'silver', 'Silver Agent', '🥈', '#a8a9ad', 30.00, 'Minimum 10 referrals OR 500,000 RWF in total revenue generated.', NULL, NULL),
(3, 'gold', 'Gold Agent', '🥇', '#ffd700', 35.00, 'Minimum 30 referrals OR 2,000,000 RWF in total revenue generated.', NULL, NULL),
(4, 'elite', 'Elite Agent', '⭐', '#1a2d5a', 40.00, 'Minimum 75 referrals OR 10,000,000 RWF in total revenue generated.', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `agent_reviews`
--

CREATE TABLE `agent_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` tinyint(4) NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agent_service`
--

CREATE TABLE `agent_service` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agent_stats`
--

CREATE TABLE `agent_stats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `level_id` bigint(20) UNSIGNED NOT NULL,
  `total_referrals` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `total_revenue_generated` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `total_commissions_earned` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `total_commissions_paid` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `pending_payout` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `last_level_upgrade_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','paid','expired','active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `slug`, `content`, `status`, `start_date`, `end_date`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Welcome to Imari — Rwanda\'s New Property Marketplace', 'welcome-to-imari-rwandas-new-property-marketplace', 'We are thrilled to announce the official launch of Imari, Rwanda\'s most comprehensive online property marketplace. Whether you are buying, selling, or renting residential and commercial properties, or searching for prime land across all five provinces, Imari connects you with verified agents, certified professionals, and thousands of listings updated daily. Create your free account today to save searches, receive instant alerts, and connect directly with property owners and agents. We look forward to transforming how Rwanda transacts in real estate.', 'active', '2026-03-09', '2026-04-13', 1, '2026-03-14 13:46:18', '2026-03-25 09:01:30', '2026-03-25 09:01:30'),
(2, 'Introducing Verified Agent Badges — Raising the Bar for Rwandan Real Estate', 'introducing-verified-agent-badges-raising-the-bar-for-rwandan-real-estate', 'Imari is proud to launch its Agent Verification Programme. All agents displaying the blue \"Verified\" badge have submitted valid national ID, proof of professional registration, and undergone a background screening conducted in partnership with the Rwanda Investigation Bureau (RIB). Verified agents are also required to adhere to Imari\'s Code of Conduct, which prohibits double-commission practices, misleading listing descriptions, and undisclosed conflicts of interest. Look for the badge when choosing your agent — your security is our priority.', 'active', '2026-03-11', '2026-05-13', 1, '2026-03-14 13:46:18', '2026-03-25 09:01:36', '2026-03-25 09:01:36'),
(3, 'Imari at the Kigali Real Estate & Construction Expo 2025', 'imari-at-the-kigali-real-estate-construction-expo-2025', 'Imari will be exhibiting at the Kigali Real Estate & Construction Expo taking place at the Kigali Convention Centre from 14–16 August 2025. Visit us at Stand B-07 to meet our team, explore our premium listing packages, and attend our panel discussion on \"Digital Innovation in Rwanda\'s Property Market\" scheduled for 15 August at 11:00 AM. The expo is free to attend and open to property buyers, investors, developers, and industry professionals. Register your interest at the expo website.', 'active', '2026-03-16', '2026-04-28', 1, '2026-03-14 13:46:18', '2026-03-25 09:02:06', '2026-03-25 09:02:06'),
(4, 'Limited Offer: List Your Property for Free — July 2025', 'limited-offer-list-your-property-for-free-july-2025', 'Throughout July 2025, all new property owners and landlords joining Imari can list up to three properties at absolutely no cost. This includes houses, apartments, land, and commercial properties. Each free listing includes full photo upload, map pin, description, contact details, and visibility in our standard search results. To take advantage of this offer, register your account before 31 July 2025 and use the promo code IMARI-FREE at the listing checkout. Terms and conditions apply — offer valid for individual landlords only, not agencies.', 'active', '2026-03-14', '2026-04-14', 1, '2026-03-14 13:46:18', '2026-03-25 09:02:17', '2026-03-25 09:02:17'),
(5, 'Scheduled Maintenance — Sunday 20 July 2025, 02:00–06:00 AM', 'scheduled-maintenance-sunday-20-july-2025-0200-0600-am', 'Imari will undergo scheduled platform maintenance on Sunday 20 July 2025 between 02:00 AM and 06:00 AM (East Africa Time). During this window, the website and mobile application will be temporarily unavailable. We apologise for any inconvenience this may cause. The maintenance is necessary to deploy infrastructure upgrades that will significantly improve platform speed, search performance, and map loading times. All data will be fully preserved. If you have urgent enquiries, please contact our support team via WhatsApp on +250 788 000 100 before or after the maintenance window.', 'active', '2026-03-15', '2026-03-29', 1, '2026-03-14 13:46:18', '2026-03-25 09:02:25', '2026-03-25 09:02:25'),
(6, 'New Feature: Find Architects, Lawyers & Surveyors on Imari', 'new-feature-find-architects-lawyers-surveyors-on-imari', 'Imari has launched its Professional Services Directory — a curated marketplace of verified architects, structural engineers, land surveyors, property valuers, building contractors, real estate lawyers, interior designers, MEP engineers, landscape architects, and urban planners. Every professional listed has submitted their RCIC, REB, RLMUA, or RBA registration certificate for verification. You can now search professionals by discipline, location, language, and years of experience, read client reviews, and request a quote — all directly through the Imari platform. Navigate to the \"Professionals\" section to explore.', 'active', '2026-03-13', '2026-06-12', 1, '2026-03-14 13:46:18', '2026-03-25 09:02:54', '2026-03-25 09:02:54'),
(7, 'Imari Tenders: Construction & Property Procurement Notices Now Live', 'imari-tenders-construction-property-procurement-notices-now-live', 'We are pleased to announce the launch of Imari Tenders, a dedicated section for construction and property-related procurement notices from government institutions, districts, parastatals, and private developers across Rwanda. Contractors, consultants, and suppliers can now browse open tenders, download bidding documents, and set up alerts for tender categories matching their expertise. Institutions wishing to publish tender notices on Imari can contact our business team at tenders@imari.rw for competitive publishing packages. All tenders are displayed exactly as submitted by the procuring entities.', 'active', '2026-03-12', '2026-07-12', 1, '2026-03-14 13:46:18', '2026-03-25 09:02:50', '2026-03-25 09:02:50'),
(8, 'Coming Soon: Apply for a Home Loan Directly on Imari', 'coming-soon-apply-for-a-home-loan-directly-on-imari', 'Imari is partnering with three leading Rwandan commercial banks to bring mortgage pre-qualification and home loan applications directly within the platform. Soon, when you find your ideal property on Imari, you will be able to calculate your monthly repayments, check your eligibility, and submit a loan application — all without leaving the page. Our banking partners will be announced at the Kigali Real Estate Expo in August. Stay tuned for this exciting development that will make home ownership more accessible than ever for Rwandans.', 'inactive', '2026-04-23', '2026-07-12', 1, '2026-03-14 13:46:18', '2026-03-25 09:02:45', '2026-03-25 09:02:45'),
(9, 'Early Adopter Discount — 50% Off Premium Listings (Expired)', 'early-adopter-discount-50-off-premium-listings-expired', 'As a thank-you to our founding users, Imari offered a 50% discount on all Premium and Featured Listing packages throughout June 2025. This promotion has now ended. We are grateful to the hundreds of agents, landlords, and developers who joined Imari during our early phase and helped shape our platform. Premium listing packages at standard pricing are still available and offer significantly enhanced visibility, featured placement in search results, social media promotion, and a dedicated account manager. Visit the Pricing page for current rates.', 'inactive', '2026-01-28', '2026-03-09', 1, '2026-03-14 13:46:18', '2026-03-25 09:02:40', '2026-03-25 09:02:40'),
(10, 'Updated Listing Policy: Accurate Pricing & UPI Compliance', 'updated-listing-policy-accurate-pricing-upi-compliance', 'Effective 1 July 2025, all land and property listings on Imari must display an accurate asking price in Rwandan Francs (RWF) and, for land listings, include a valid UPI (Uburenganzira bwo Gukoresha Ubutaka) reference number where a title deed exists. Listings without a price will no longer appear in standard search results and will be marked as \"Price on Application\" only with agent-tier accounts. This policy update is designed to improve transparency and trust for property seekers on our platform. Listings that do not comply by 15 July 2025 will be temporarily suspended pending correction. Please update your listings through your dashboard.', 'active', '2026-03-13', '2026-05-03', 1, '2026-03-14 13:46:18', '2026-03-25 09:02:35', '2026-03-25 09:02:35');

-- --------------------------------------------------------

--
-- Table structure for table `architectural_designs`
--

CREATE TABLE `architectural_designs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `listing_package_id` bigint(20) UNSIGNED DEFAULT NULL,
  `listing_days` int(11) NOT NULL DEFAULT '30',
  `listing_fee_total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `agent_listing_commission` decimal(12,2) NOT NULL DEFAULT '0.00',
  `terra_listing_revenue` decimal(12,2) NOT NULL DEFAULT '0.00',
  `owner_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_id_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `design_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `preview_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `is_free` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `download_count` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `architectural_designs`
--

INSERT INTO `architectural_designs` (`id`, `title`, `slug`, `user_id`, `agent_id`, `added_by`, `listing_package_id`, `listing_days`, `listing_fee_total`, `agent_listing_commission`, `terra_listing_revenue`, `owner_name`, `owner_email`, `owner_phone`, `owner_id_number`, `category_id`, `service_id`, `description`, `design_file`, `preview_image`, `price`, `is_free`, `status`, `featured`, `download_count`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Modern 3Bedrooms Bungalow plan', 'modern-3bedrooms-bungalow-plan-1773911030', NULL, NULL, NULL, NULL, 30, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, 2, 4, '6Rooms', 'architectural_designs/files/XE22vCBAkygqNCBYmVFRlCy7bXKrjfhzSwunHxlp.pdf', 'architectural_designs/previews/yT5RlpKniythDpXTaBUYnNr7rlx1SMQmGRvG3GE5.jpg', 0.00, 1, 'approved', 1, 2, '2026-03-19 07:03:50', '2026-03-25 09:08:11', '2026-03-25 09:08:11'),
(2, 'Modern', 'modern-1773915871', NULL, NULL, NULL, NULL, 30, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, 2, 1, 'Testing', 'architectural_designs/files/KZwd2uejOcHh66cPqKfovOr3ZCitmRfM8vceWaFx.pdf', 'architectural_designs/previews/Hi9wfYSr8oXXs3sYgZO7iDtuSMprBcKlOPQgNNfy.jpg', 0.00, 1, 'pending', 0, 0, '2026-03-19 08:24:31', '2026-03-25 09:08:23', '2026-03-25 09:08:23'),
(3, '6bedrom', '6bedrom-1773916091', NULL, NULL, NULL, NULL, 30, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, 10, 1, 'testing', 'architectural_designs/files/i02ERaIQ3ksTvpF0M2mYr6nmowOnf7suhzNnnGR7.pdf', 'architectural_designs/previews/Yt0luzWtjQokqw8G1ey1lAuE0b7O7pqmztKHt2gt.png', 0.00, 1, 'pending', 0, 0, '2026-03-19 08:28:12', '2026-03-25 09:08:35', '2026-03-25 09:08:35'),
(4, '5 rooms', '5-rooms-1773916259', NULL, NULL, NULL, NULL, 30, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, 5, 2, 'High quality', 'architectural_designs/files/USPgjICRxVjKV5wsuTWIaj0H8C54d4R2Ure7ZjCx.pdf', 'architectural_designs/previews/fH6GQKojzMgpqNvKx8wQbTlzc9O7lWrFqvpYH85U.jpg', 2000000.00, 0, 'pending', 0, 0, '2026-03-19 08:30:59', '2026-03-25 09:42:00', '2026-03-25 09:42:00'),
(5, '5 rooms', '5-rooms-1773916263', NULL, NULL, NULL, NULL, 30, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, 5, 2, 'High quality', 'architectural_designs/files/PKaqJMsNOWAmNh2ZcCkF5Fv24pfzlTN1zsSD7bvI.pdf', 'architectural_designs/previews/2l04HEUVqGud43GIMWb3nkCl2MDOP2yn5I3IY2QN.jpg', 2000000.00, 0, 'pending', 0, 0, '2026-03-19 08:31:04', '2026-03-25 09:07:59', '2026-03-25 09:07:59'),
(6, '5 rooms', '5-rooms-1773916268', NULL, NULL, NULL, NULL, 30, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, 5, 2, 'High quality', 'architectural_designs/files/ODnN0BpkQkC9b1Mz61tUseV9heYLVeg1nFZ07qHD.pdf', 'architectural_designs/previews/ooxX9k8rRPosWjdd4M6UuOTIi01THDXeoL42Ygvc.jpg', 2000000.00, 0, 'pending', 0, 0, '2026-03-19 08:31:08', '2026-03-25 08:58:09', '2026-03-25 08:58:09'),
(7, '543 bedrom', '543-bedrom-1773916310', NULL, NULL, NULL, NULL, 30, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, 9, 9, 'Tasting', 'architectural_designs/files/8aXNsiFVxXBIIiogfUL7Wlj8675VVkaMIoHI6d8f.pdf', 'architectural_designs/previews/IfnelQvfxOod6cf0FgtwD7bvseplahkyBMWT1bq2.png', 0.00, 1, 'pending', 0, 0, '2026-03-19 08:31:52', '2026-03-23 08:54:36', '2026-03-23 08:54:36');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `blog_category_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('terra-real-estate-cache-admin@admin.com|129.222.149.31', 'i:1;', 1774433017),
('terra-real-estate-cache-admin@admin.com|129.222.149.31:timer', 'i:1774433016;', 1774433016),
('terra-real-estate-cache-admin@terrarealestate.rw|41.186.136.67', 'i:2;', 1774254151),
('terra-real-estate-cache-admin@terrarealestate.rw|41.186.136.67:timer', 'i:1774254151;', 1774254151),
('terra-real-estate-cache-augustin@2026|197.157.185.41', 'i:1;', 1773919896),
('terra-real-estate-cache-augustin@2026|197.157.185.41:timer', 'i:1773919896;', 1773919896),
('terra-real-estate-cache-jackynezaa@gmail.com|197.157.187.172', 'i:1;', 1773822598),
('terra-real-estate-cache-jackynezaa@gmail.com|197.157.187.172:timer', 'i:1773822598;', 1773822598),
('terra-real-estate-cache-jackynezaa@gmail.com|197.157.187.179', 'i:1;', 1774532929),
('terra-real-estate-cache-jackynezaa@gmail.com|197.157.187.179:timer', 'i:1774532929;', 1774532929),
('terra-real-estate-cache-jackynezaa@gmail.com|197.157.187.50', 'i:2;', 1773916577),
('terra-real-estate-cache-jackynezaa@gmail.com|197.157.187.50:timer', 'i:1773916577;', 1773916577),
('terra-real-estate-cache-kezaornella@gmai.com|197.157.187.50', 'i:1;', 1773919714),
('terra-real-estate-cache-kezaornella@gmai.com|197.157.187.50:timer', 'i:1773919714;', 1773919714),
('terra-real-estate-cache-misagoflorien@gmail.com|41.186.137.178', 'i:1;', 1773729293),
('terra-real-estate-cache-misagoflorien@gmail.com|41.186.137.178:timer', 'i:1773729293;', 1773729293),
('terra-real-estate-cache-pascaliyakaremye6@gmail.com|41.186.135.100', 'i:1;', 1774532198),
('terra-real-estate-cache-pascaliyakaremye6@gmail.com|41.186.135.100:timer', 'i:1774532198;', 1774532198),
('terra-real-estate-cache-test@gamil.com|41.186.132.32', 'i:2;', 1773769589),
('terra-real-estate-cache-test@gamil.com|41.186.132.32:timer', 'i:1773769589;', 1773769589);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cells`
--

CREATE TABLE `cells` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sector_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `consultants`
--

CREATE TABLE `consultants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `registration_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `consultant_appointments`
--

CREATE TABLE `consultant_appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `consultant_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `consultant_commissions`
--

CREATE TABLE `consultant_commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `consultant_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_value` bigint(20) UNSIGNED NOT NULL,
  `commission_tier_id` bigint(20) UNSIGNED NOT NULL,
  `terra_commission_pct` decimal(5,2) NOT NULL,
  `consultant_payout_pct` decimal(5,2) NOT NULL,
  `terra_commission_amount` bigint(20) UNSIGNED NOT NULL,
  `consultant_payout_amount` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `consultant_commission_tiers`
--

CREATE TABLE `consultant_commission_tiers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `min_value` bigint(20) UNSIGNED NOT NULL,
  `max_value` bigint(20) UNSIGNED DEFAULT NULL,
  `terra_commission_pct` decimal(5,2) NOT NULL,
  `consultant_payout_pct` decimal(5,2) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consultant_commission_tiers`
--

INSERT INTO `consultant_commission_tiers` (`id`, `min_value`, `max_value`, `terra_commission_pct`, `consultant_payout_pct`, `label`, `created_at`, `updated_at`) VALUES
(1, 0, 29999, 30.00, 70.00, 'Under 30,000 RWF', NULL, NULL),
(2, 30000, 99999, 29.00, 71.00, '30,000 – 99,999 RWF', NULL, NULL),
(3, 100000, 299999, 28.00, 72.00, '100,000 – 299,999 RWF', NULL, NULL),
(4, 300000, 499999, 27.00, 73.00, '300,000 – 499,999 RWF', NULL, NULL),
(5, 500000, 999999, 26.00, 74.00, '500,000 – 999,999 RWF', NULL, NULL),
(6, 1000000, 4999999, 25.00, 75.00, '1,000,000 – 4,999,999 RWF', NULL, NULL),
(7, 5000000, NULL, 24.00, 76.00, '5,000,000 RWF and above', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `consultant_reviews`
--

CREATE TABLE `consultant_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `consultant_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` tinyint(4) NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `consultant_service_category`
--

CREATE TABLE `consultant_service_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `consultant_id` bigint(20) UNSIGNED NOT NULL,
  `service_category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `code`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Partnership', 'TERRAPD', 'Partnership department', 1, '2026-03-25 09:50:07', '2026-03-25 09:50:07'),
(2, 'Operations', 'TERRAOD', 'Operations department', 1, '2026-03-25 09:51:05', '2026-03-25 09:51:05'),
(3, 'Marketing & IT', 'TERRAMID', 'Marketing and IT department', 1, '2026-03-25 09:51:59', '2026-03-25 09:51:59'),
(4, 'Administration', 'TERRAAD', 'Administration Department', 1, '2026-03-25 10:01:07', '2026-03-25 10:01:07');

-- --------------------------------------------------------

--
-- Table structure for table `design_categories`
--

CREATE TABLE `design_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `design_categories`
--

INSERT INTO `design_categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Residential', 'residential', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(2, 'Commercial', 'commercial', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(3, 'Industrial', 'industrial', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(4, 'Mixed-Use', 'mixed-use', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(5, 'Hospitality & Tourism', 'hospitality-tourism', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(6, 'Institutional & Public', 'institutional-public', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(7, 'Eco & Sustainable', 'eco-sustainable', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(8, 'Landscape & Outdoor', 'landscape-outdoor', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(9, 'Interior Design', 'interior-design', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(10, 'Urban Planning', 'urban-planning', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(11, 'Religious & Cultural', 'religious-cultural', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(12, 'Renovation & Remodelling', 'renovation-remodelling', '2026-03-14 13:46:17', '2026-03-14 13:46:17');

-- --------------------------------------------------------

--
-- Table structure for table `design_orders`
--

CREATE TABLE `design_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `architectural_design_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_status` enum('pending','paid','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `duration_discounts`
--

CREATE TABLE `duration_discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `min_days` int(10) UNSIGNED NOT NULL,
  `max_days` int(10) UNSIGNED DEFAULT NULL,
  `discount_pct` decimal(5,2) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `duration_discounts`
--

INSERT INTO `duration_discounts` (`id`, `min_days`, `max_days`, `discount_pct`, `label`, `created_at`, `updated_at`) VALUES
(1, 31, 59, 10.00, '31 – 59 Days', NULL, NULL),
(2, 61, 89, 15.00, '61 – 89 Days', NULL, NULL),
(3, 90, NULL, 20.00, '90+ Days', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Pool', 'pool', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(2, 'Gym', 'gym', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(3, 'Fireplace', 'fireplace', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(4, 'Garage', 'garage', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(5, 'Balcony', 'balcony', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(6, 'Garden', 'garden', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(7, 'Swimming Pool', 'swimming-pool', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(8, 'Sauna', 'sauna', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(9, 'Spa', 'spa', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(10, 'Terrace', 'terrace', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(11, 'View', 'view', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(12, 'Elevator', 'elevator', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(13, '24/7 Security', '247-security', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(14, 'Parking', 'parking', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(15, 'Playground', 'playground', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(16, 'Storage', 'storage', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(17, 'Air Conditioning', 'air-conditioning', '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(18, 'jav', 'jav', '2026-03-19 09:10:57', '2026-03-19 09:10:57');

-- --------------------------------------------------------

--
-- Table structure for table `facility_house`
--

CREATE TABLE `facility_house` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `house_id` bigint(20) UNSIGNED NOT NULL,
  `facility_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `houses`
--

CREATE TABLE `houses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `listing_package_id` bigint(20) UNSIGNED DEFAULT NULL,
  `listing_days` int(11) NOT NULL DEFAULT '30',
  `listing_fee_total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `agent_listing_commission` decimal(12,2) NOT NULL DEFAULT '0.00',
  `terra_listing_revenue` decimal(12,2) NOT NULL DEFAULT '0.00',
  `owner_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_id_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `upi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `area_sqft` int(11) NOT NULL,
  `status` enum('available','reserved','sold') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `condition` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'for_sale',
  `bedrooms` int(11) NOT NULL,
  `bathrooms` int(11) NOT NULL,
  `garages` int(11) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sector` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cell` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `village` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `house_images`
--

CREATE TABLE `house_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `house_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lands`
--

CREATE TABLE `lands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `listing_package_id` bigint(20) UNSIGNED DEFAULT NULL,
  `listing_days` int(11) NOT NULL DEFAULT '30',
  `listing_fee_total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `agent_listing_commission` decimal(12,2) NOT NULL DEFAULT '0.00',
  `terra_listing_revenue` decimal(12,2) NOT NULL DEFAULT '0.00',
  `owner_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_id_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(15,2) NOT NULL,
  `size_sqm` decimal(12,2) NOT NULL,
  `zoning` enum('R1','R2','R3','Commercial','Industrial','Agricultural') COLLATE utf8mb4_unicode_ci NOT NULL,
  `land_use` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sector` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cell` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `village` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `upi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_doc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_title_verified` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('available','reserved','sold') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `land_images`
--

CREATE TABLE `land_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `land_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `listings`
--

CREATE TABLE `listings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `listing_package_id` bigint(20) UNSIGNED NOT NULL,
  `listing_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_tier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `duration_days` int(10) UNSIGNED NOT NULL,
  `base_price_per_day` bigint(20) UNSIGNED NOT NULL,
  `gross_amount` bigint(20) UNSIGNED NOT NULL,
  `duration_discount_pct` decimal(5,2) NOT NULL DEFAULT '0.00',
  `discount_amount` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `net_amount` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `paid_at` timestamp NULL DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `listing_commissions`
--

CREATE TABLE `listing_commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `listing_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `listing_package_id` bigint(20) UNSIGNED NOT NULL,
  `listing_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_tier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `net_listing_amount` bigint(20) UNSIGNED NOT NULL,
  `agent_commission_pct` decimal(5,2) NOT NULL,
  `agent_commission_amount` bigint(20) UNSIGNED NOT NULL,
  `terra_share_amount` bigint(20) UNSIGNED NOT NULL,
  `agent_level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `performance_bonus_pct` decimal(5,2) NOT NULL DEFAULT '0.00',
  `performance_bonus_amount` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `total_agent_payout` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `listing_packages`
--

CREATE TABLE `listing_packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `listing_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_tier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_per_day` bigint(20) UNSIGNED NOT NULL,
  `agent_commission_pct` decimal(5,2) NOT NULL,
  `terra_share_pct` decimal(5,2) NOT NULL,
  `features` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `listing_packages`
--

INSERT INTO `listing_packages` (`id`, `listing_type`, `package_tier`, `price_per_day`, `agent_commission_pct`, `terra_share_pct`, `features`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'land', 'basic', 6777, 20.00, 80.00, NULL, 1, '2026-03-14 15:40:46', '2026-03-23 08:39:44'),
(2, 'land', 'medium', 5000, 20.00, 80.00, NULL, 1, '2026-03-14 15:40:46', '2026-03-23 08:40:52'),
(3, 'land', 'standard', 3500, 20.00, 80.00, NULL, 1, '2026-03-14 15:40:46', '2026-03-14 15:40:46'),
(4, 'house', 'basic', 1500, 20.00, 80.00, NULL, 1, '2026-03-14 15:40:46', '2026-03-14 15:40:46'),
(5, 'house', 'medium', 3000, 20.00, 80.00, NULL, 1, '2026-03-14 15:40:46', '2026-03-14 15:40:46'),
(6, 'house', 'standard', 4000, 20.00, 80.00, NULL, 1, '2026-03-14 15:40:46', '2026-03-14 15:40:46'),
(7, 'design', 'basic', 200, 25.00, 75.00, NULL, 1, '2026-03-14 15:40:46', '2026-03-14 15:40:46'),
(8, 'design', 'medium', 350, 25.00, 75.00, NULL, 1, '2026-03-14 15:40:46', '2026-03-14 15:40:46'),
(9, 'design', 'standard', 500, 25.00, 75.00, NULL, 1, '2026-03-14 15:40:46', '2026-03-14 15:40:46'),
(10, 'tender', 'basic', 1500, 20.00, 80.00, NULL, 1, '2026-03-14 15:40:46', '2026-03-14 15:40:46'),
(11, 'tender', 'medium', 2000, 20.00, 80.00, NULL, 1, '2026-03-14 15:40:46', '2026-03-14 15:40:46'),
(12, 'tender', 'standard', 3000, 20.00, 80.00, NULL, 1, '2026-03-14 15:40:47', '2026-03-14 15:40:47'),
(13, 'advertisement', 'basic', 2000, 20.00, 80.00, NULL, 1, '2026-03-14 15:40:47', '2026-03-14 15:40:47'),
(14, 'advertisement', 'medium', 3000, 20.00, 80.00, NULL, 1, '2026-03-14 15:40:47', '2026-03-14 15:40:47'),
(15, 'advertisement', 'standard', 4000, 20.00, 80.00, NULL, 1, '2026-03-14 15:40:47', '2026-03-14 15:40:47');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_06_183022_add_role_to_users_table', 1),
(5, '2026_02_06_183303_create_properties_table', 1),
(6, '2026_02_06_183447_create_property_media_table', 1),
(7, '2026_02_07_103420_create_service_categories_table', 1),
(8, '2026_02_07_103421_create_service_sub_categories_table', 1),
(9, '2026_02_07_103422_create_services_table', 1),
(10, '2026_02_07_103426_create_houses_table', 1),
(11, '2026_02_07_103501_create_house_images_table', 1),
(12, '2026_02_07_103511_create_facilities_table', 1),
(13, '2026_02_07_103520_create_facility_house_table', 1),
(14, '2026_02_07_125003_create_lands_table', 1),
(15, '2026_02_07_143010_create_agents_table', 1),
(16, '2026_02_09_090008_create_professionals_table', 1),
(17, '2026_02_09_114224_create_tenders_table', 1),
(18, '2026_02_19_151727_create_design_categories_table', 1),
(19, '2026_02_19_151728_create_architectural_designs_table', 1),
(20, '2026_02_19_152110_create_design_orders_table', 1),
(21, '2026_02_20_084047_create_announcements_table', 1),
(22, '2026_02_27_151314_create_consultants_table', 1),
(23, '2026_02_27_151849_create_consultant_service_category_table', 1),
(24, '2026_02_28_071327_create_agent_reviews_table', 1),
(25, '2026_02_28_071608_create_agent_appointments_table', 1),
(26, '2026_02_28_073039_create_consultant_reviews_table', 1),
(27, '2026_02_28_073058_create_consultant_appointments_table', 1),
(28, '2026_02_28_080752_create_advertisements_table', 1),
(29, '2026_03_04_175842_create_agent_service_table', 1),
(30, '2026_03_05_082440_create_pricing_plans_table', 1),
(31, '2026_03_05_082931_create_property_plan_orders_table', 1),
(32, '2026_03_05_083037_create_payments_table', 1),
(33, '2026_03_05_083129_add_plan_fields_to_properties_table', 1),
(34, '2026_03_05_200143_create_land_images_table', 1),
(35, '2026_03_06_071843_create_partners_table', 1),
(36, '2026_03_06_082130_create_blog_categories_table', 1),
(37, '2026_03_06_082136_create_blogs_table', 1),
(38, '2026_03_08_151323_create_departments_table', 1),
(39, '2026_03_08_165025_create_locations_table', 1),
(40, '2026_03_09_081721_create_roles_table', 1),
(41, '2026_03_09_081751_create_permissions_table', 1),
(42, '2026_03_09_081829_create_role_permissions_table', 1),
(43, '2026_03_09_081902_create_staff_table', 1),
(44, '2026_03_13_115538_create_listing_packages_table', 1),
(45, '2026_03_13_115846_create_commission_tiers_table', 1),
(46, '2026_03_13_120053_create_listings_commissions_table', 1),
(47, '2026_03_16_202607_create_terra_jobs_table', 2),
(48, '2026_03_19_080306_create_terra_job_applications_table', 2),
(49, '2026_03_22_165818_add_listing_fields_to_houses_table', 3),
(50, '2026_03_22_165818_add_listing_fields_to_lands_table', 3),
(51, '2026_03_22_165819_add_listing_fields_to_architectural_designs_table', 3),
(52, '2026_03_22_165820_add_level_to_agents_table', 3),
(53, '2026_03_22_165822_create_agent_commissions_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_plan_order_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','success','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `property_plan_order_id`, `amount`, `payment_method`, `transaction_id`, `status`, `created_at`, `updated_at`) VALUES
(2, 2, 3000.00, 'MoMo', 'TERRA-69B59A35CC0F4', 'success', '2026-03-14 15:26:13', '2026-03-14 15:26:13'),
(3, 4, 6000.00, 'MoMo', 'TERRA-69BBC28F99127', 'success', '2026-03-19 07:31:59', '2026-03-19 07:31:59'),
(4, 5, 1500.00, 'MoMo', 'TERRA-69BBC5B0CF327', 'success', '2026-03-19 07:45:20', '2026-03-19 07:45:20'),
(9, 9, 7500.00, 'MoMo', 'TERRA-69BBCE51B4256', 'success', '2026-03-19 08:22:09', '2026-03-19 08:22:09'),
(11, 11, 9000.00, 'MoMo', 'TERRA-69BBCEE0BA65C', 'success', '2026-03-19 08:24:32', '2026-03-19 08:24:32'),
(13, 13, 3000.00, 'MoMo', 'TERRA-69BBD7A85F9BC', 'success', '2026-03-19 09:02:00', '2026-03-19 09:02:00'),
(14, 14, 3000.00, 'MoMo', 'TERRA-69BBDFDF965CD', 'success', '2026-03-19 09:37:03', '2026-03-19 09:37:03'),
(16, 16, 3000.00, 'MoMo', 'TERRA-69C0F769B2920', 'success', '2026-03-23 06:18:49', '2026-03-23 06:18:49'),
(22, 22, 1500.00, 'MoMo', 'TERRA-69C277E022879', 'success', '2026-03-24 09:39:12', '2026-03-24 09:39:12'),
(23, 23, 3000.00, 'MoMo', 'TERRA-69C3E104B6B51', 'success', '2026-03-25 11:20:04', '2026-03-25 11:20:04'),
(24, 23, 3000.00, 'MoMo', 'TERRA-69C3E11CE3FC1', 'success', '2026-03-25 11:20:28', '2026-03-25 11:20:28'),
(25, 24, 3000.00, 'MoMo', 'TERRA-69C3E347AD8ED', 'success', '2026-03-25 11:29:43', '2026-03-25 11:29:43');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pricing_plans`
--

CREATE TABLE `pricing_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price_per_day` decimal(10,2) NOT NULL,
  `max_images` int(11) DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `priority_listing` tinyint(1) NOT NULL DEFAULT '0',
  `show_on_homepage` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pricing_plans`
--

INSERT INTO `pricing_plans` (`id`, `name`, `description`, `price_per_day`, `max_images`, `featured`, `priority_listing`, `show_on_homepage`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Free', 'Get started at no cost. List your property on Imari and reach thousands of buyers and renters across Rwanda. The Free plan is perfect for individual landlords and first-time sellers who want basic visibility without any upfront investment. Your listing will appear in standard search results with up to 3 photos.', 0.00, 3, 0, 0, 0, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(2, 'Basic', 'Upgrade to the Basic plan for enhanced visibility at an affordable daily rate. Your listing will appear higher in search results with up to 8 photos to showcase your property. Ideal for landlords and small agencies looking to attract more enquiries without a large marketing budget. Includes a \"Basic\" badge on your listing.', 1500.00, 8, 0, 0, 0, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(3, 'Standard', 'The Standard plan gives your property significantly boosted exposure across the Imari platform. Listings are prioritised in search results, support up to 15 high-resolution photos, and are displayed with a \"Standard\" badge. Standard listings also receive periodic promotion via Imari\'s social media channels. Recommended for agents and developers with active portfolios.', 4000.00, 15, 0, 1, 0, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(4, 'Premium', 'The Premium plan is designed for serious sellers and agents who want maximum results. Your listing is marked as Featured, placed in the priority search index, and displayed in the dedicated Featured Properties section on the Imari homepage. Supports up to 25 photos, a video embed link, and a virtual tour URL. Premium listings receive a dedicated account manager and weekly performance reports.', 9000.00, 25, 1, 1, 1, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(5, 'Elite', 'The Elite plan is Imari\'s most powerful listing package, reserved for flagship properties and top-performing agencies. Elite listings are pinned at the very top of all relevant search results, prominently featured on the homepage hero carousel, and promoted via targeted email campaigns to Imari\'s verified buyer and investor database. Includes unlimited photos, a 3D virtual tour embed, a dedicated landing page, and fortnightly consultation calls with the Imari marketing team.', 20000.00, 100, 1, 1, 1, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(7, 'Developer Pack', 'Built for property developers launching multi-unit projects such as apartment blocks, gated estates, or commercial complexes. The Developer Pack allows a single project to be listed as a development with individual units beneath it, each with its own photos and pricing. The parent project listing appears in the Homepage New Developments section, and the developer receives a dedicated project microsite on the Imari platform. Supports unlimited images across the project.', 35000.00, 100, 1, 1, 1, 1, '2026-03-14 13:46:18', '2026-03-14 13:46:18'),
(8, 'Starter Pro (Legacy)', 'This plan has been retired and is no longer available for new subscriptions. It was an introductory plan offered during Imari\'s beta launch phase. Existing active orders under this plan will be honoured until their expiry date. Subscribers are encouraged to migrate to the Basic or Standard plan to continue enjoying enhanced features.', 2500.00, 10, 0, 0, 0, 0, '2026-03-14 13:46:18', '2026-03-14 13:46:18');

-- --------------------------------------------------------

--
-- Table structure for table `professionals`
--

CREATE TABLE `professionals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profession` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `years_experience` int(11) NOT NULL DEFAULT '0',
  `rating` decimal(2,1) NOT NULL DEFAULT '0.0',
  `bio` text COLLATE utf8mb4_unicode_ci,
  `services` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `portfolio_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credentials_doc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `office_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `languages` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('house','land') COLLATE utf8mb4_unicode_ci NOT NULL,
  `zoning` enum('R1','R2','R3','Commercial','Industrial') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(15,2) NOT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sector` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cell` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('available','reserved','sold') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `plan_expiry_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property_media`
--

CREATE TABLE `property_media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('image','title_doc') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property_plan_orders`
--

CREATE TABLE `property_plan_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `pricing_plan_id` bigint(20) UNSIGNED NOT NULL,
  `days` int(11) NOT NULL,
  `price_per_day` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `payment_status` enum('pending','paid','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_plan_orders`
--

INSERT INTO `property_plan_orders` (`id`, `property_type`, `property_id`, `user_id`, `pricing_plan_id`, `days`, `price_per_day`, `total_price`, `start_date`, `end_date`, `payment_status`, `created_at`, `updated_at`) VALUES
(2, 'App\\Models\\Land', 1, 7, 2, 2, 1500.00, 3000.00, NULL, NULL, 'paid', '2026-03-14 15:26:04', '2026-03-14 15:26:13'),
(4, 'App\\Models\\House', 3, 57, 2, 4, 1500.00, 6000.00, NULL, NULL, 'paid', '2026-03-19 07:31:37', '2026-03-19 07:31:59'),
(5, 'App\\Models\\House', 4, 58, 2, 1, 1500.00, 1500.00, NULL, NULL, 'paid', '2026-03-19 07:45:13', '2026-03-19 07:45:20'),
(9, 'App\\Models\\Land', 4, 57, 2, 5, 1500.00, 7500.00, NULL, NULL, 'paid', '2026-03-19 08:21:46', '2026-03-19 08:22:09'),
(11, 'App\\Models\\House', 9, 59, 2, 6, 1500.00, 9000.00, NULL, NULL, 'paid', '2026-03-19 08:24:08', '2026-03-19 08:24:32'),
(13, 'App\\Models\\House', 10, 61, 2, 2, 1500.00, 3000.00, NULL, NULL, 'paid', '2026-03-19 09:01:51', '2026-03-19 09:02:00'),
(14, 'App\\Models\\House', 11, 64, 2, 2, 1500.00, 3000.00, NULL, NULL, 'paid', '2026-03-19 09:36:57', '2026-03-19 09:37:03'),
(16, 'App\\Models\\Land', 6, 68, 2, 2, 1500.00, 3000.00, NULL, NULL, 'paid', '2026-03-23 06:18:42', '2026-03-23 06:18:49'),
(22, 'App\\Models\\House', 17, 41, 2, 1, 1500.00, 1500.00, NULL, NULL, 'paid', '2026-03-24 09:39:03', '2026-03-24 09:39:12'),
(23, 'App\\Models\\House', 18, 41, 2, 2, 1500.00, 3000.00, NULL, NULL, 'paid', '2026-03-25 11:19:48', '2026-03-25 11:20:04'),
(24, 'App\\Models\\Land', 9, 41, 2, 2, 1500.00, 3000.00, NULL, NULL, 'paid', '2026-03-25 11:29:24', '2026-03-25 11:29:43'),
(25, 'App\\Models\\Land', 10, 41, 1, 60, 0.00, 0.00, NULL, NULL, 'pending', '2026-03-27 13:40:49', '2026-03-27 13:40:49');

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sectors`
--

CREATE TABLE `sectors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_category_id` bigint(20) UNSIGNED NOT NULL,
  `service_subcategory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `is_paid` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `display_order` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_category_id`, `service_subcategory_id`, `title`, `slug`, `description`, `price`, `is_paid`, `is_active`, `display_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, 'Sell a Single-Family Home', 'sell-a-single-family-home', 'List and sell a standalone residential house.', 0.00, 0, 1, 0, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(2, 1, 3, 'Rent an Apartment', 'rent-an-apartment', 'Rent out apartments and flats to tenants.', 0.00, 0, 1, 0, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(3, 1, 18, 'Sell Residential Land', 'sell-residential-land', 'Sell land designated for residential construction.', 0.00, 0, 1, 0, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(4, 2, 23, 'Bungalow House Plan', 'bungalow-house-plan', 'Ready-made architectural plans for bungalows.', 25000.00, 0, 1, 0, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(5, 2, 24, 'Villa Architectural Design', 'villa-architectural-design', 'Modern multi-storey villa house designs.', 50000.00, 0, 1, 0, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(6, 2, 25, 'Apartment Block Design', 'apartment-block-design', 'Architectural drawings for apartment buildings.', 100000.00, 0, 1, 0, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(7, 3, NULL, 'Featured Property Advertisement', 'featured-property-advertisement', 'Promote your property on the homepage.', 15000.00, 0, 1, 0, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(8, 3, NULL, 'Social Media Property Promotion', 'social-media-property-promotion', 'Advertise property across social media platforms.', 20000.00, 0, 1, 0, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(9, 4, 43, 'Architectural Services', 'architectural-services', 'Professional architectural consulting services.', 30000.00, 0, 1, 0, '2026-03-14 13:46:17', '2026-03-25 09:23:35', NULL),
(10, 4, 46, 'Land Surveying Services', 'land-surveying-services', 'Land measurement and boundary verification.', 40000.00, 0, 1, 0, '2026-03-14 13:46:17', '2026-03-25 09:25:32', NULL),
(11, 4, 45, 'Land Valuation Services', 'land-valuation-services', 'Official valuation of land and property.', 35000.00, 0, 1, 0, '2026-03-14 13:46:17', '2026-03-25 09:25:52', NULL),
(12, 5, NULL, 'Agent Property Listing Management', 'agent-property-listing-management', 'Agents manage listings on behalf of property owners.', 0.00, 0, 1, 0, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(14, 4, 42, 'Environmental Services', 'environmental-services', 'Environmental Services', 0.00, 0, 1, 0, '2026-03-25 09:20:10', '2026-03-25 09:26:11', NULL),
(15, 4, 44, 'Land Notary Services', 'land-notary-services', 'Land Notary Services', 0.00, 0, 1, 0, '2026-03-25 09:21:40', '2026-03-25 09:21:40', NULL),
(16, 4, 43, 'Engineering Services', 'engineering-services', 'Engineering Services', 0.00, 0, 1, 0, '2026-03-25 09:22:36', '2026-03-25 09:22:36', NULL),
(17, 4, 47, 'Urban Planning Services', 'urban-planning-services', 'Urban Planning Services', 0.00, 0, 1, 0, '2026-03-25 09:24:04', '2026-03-25 09:24:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_categories`
--

CREATE TABLE `service_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_categories`
--

INSERT INTO `service_categories` (`id`, `name`, `slug`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Buying, Selling & Renting Marketplace', 'buying-selling-renting-marketplace', 'Property buying, selling and renting services', 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(2, 'Architectural Designs & House Plans Marketplace', 'architectural-designs-house-plans-marketplace', 'Architectural drawings and house plans', 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(3, 'Marketing & Advertising Marketplace', 'marketing-advertising-marketplace', 'Property marketing and advertising services', 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(4, 'Professionals Marketplace', 'professionals-marketplace', 'Verified real estate professionals', 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17'),
(5, 'Terra Agents Room', 'terra-agents-room', 'Agents declare and manage services', 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17');

-- --------------------------------------------------------

--
-- Table structure for table `service_sub_categories`
--

CREATE TABLE `service_sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_sub_categories`
--

INSERT INTO `service_sub_categories` (`id`, `service_category_id`, `name`, `slug`, `description`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Residential Properties', 'residential-properties', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(2, 1, 'Single-Family Homes', 'single-family-homes', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(3, 1, 'Apartments / Flats', 'apartments-flats', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(4, 1, 'Studios / Bedsitters', 'studios-bedsitters', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(5, 1, 'Villas', 'villas', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(6, 1, 'Estates', 'estates', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(7, 1, 'Commercial Properties', 'commercial-properties', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(8, 1, 'Office Spaces', 'office-spaces', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(9, 1, 'Retail Stores / Shops', 'retail-stores-shops', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(10, 1, 'Warehouses', 'warehouses', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(11, 1, 'Showrooms', 'showrooms', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(12, 1, 'Hotels & Guest Houses', 'hotels-guest-houses', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(13, 1, 'Special Use Properties', 'special-use-properties', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(14, 1, 'Event Halls', 'event-halls', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(15, 1, 'Co-working Spaces', 'co-working-spaces', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(16, 1, 'Parking Lots', 'parking-lots', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(17, 1, 'Lands & Plots', 'lands-plots', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(18, 1, 'Residential Plots', 'residential-plots', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(19, 1, 'Commercial Plots', 'commercial-plots', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(20, 1, 'Agricultural Land', 'agricultural-land', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(21, 1, 'Industrial Land', 'industrial-land', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(22, 2, 'Residential Designs', 'residential-designs', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(23, 2, 'Bungalows', 'bungalows', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(24, 2, 'Storey Houses (Villas)', 'storey-houses-villas', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(25, 2, 'Apartment Blocks', 'apartment-blocks', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(26, 2, 'Tiny Houses / Studios', 'tiny-houses-studios', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(27, 2, 'Duplexes', 'duplexes', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(28, 2, 'Commercial & Mixed-Use', 'commercial-mixed-use', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(29, 2, 'Commercial Buildings / Malls', 'commercial-buildings-malls', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(30, 2, 'Office Complexes', 'office-complexes', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(31, 2, 'Warehouses', 'warehouses', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(32, 2, 'Mixed-Use Buildings', 'mixed-use-buildings', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(33, 2, 'Hospitality & Leisure', 'hospitality-leisure', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(34, 2, 'Hotels & Resorts', 'hotels-resorts', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(35, 2, 'Guest Houses / Motels', 'guest-houses-motels', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(36, 2, 'Restaurants & Cafés', 'restaurants-cafes', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(37, 2, 'Event Halls', 'event-halls', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(38, 2, 'Public & Institutional', 'public-institutional', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(39, 2, 'Clinics & Hospitals', 'clinics-hospitals', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(40, 2, 'Schools & Classrooms', 'schools-classrooms', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(41, 2, 'Places of Worship', 'places-of-worship', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(42, 4, 'Built Environment Professionals', 'built-environment-professionals', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(43, 4, 'Engineers / Architects', 'engineers-architects', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(44, 4, 'Land Notaries', 'land-notaries', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(45, 4, 'Land Valuers', 'land-valuers', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(46, 4, 'Land Surveyors', 'land-surveyors', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(47, 4, 'Urban Planners', 'urban-planners', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL),
(48, 4, 'Environmentalists', 'environmentalists', NULL, 1, '2026-03-14 13:46:17', '2026-03-14 13:46:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0lErzuvVmi8uNZkUw3pOBeVhBFZ0AEZhzQ1tq2wL', NULL, '194.163.180.153', 'Python/3.11 aiohttp/3.9.2', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRHhWenFsbzllcEI2UGRlRTc3SmVnRGdwaWxDbnZHNjBCWkJWWldCNyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHBzOi8vdGVycmEucnciO3M6NToicm91dGUiO3M6MTA6ImZyb250LmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774791560),
('6RvxjYlktUsLnizHBTIceMiTMDxIenvDGN0oprix', NULL, '43.173.179.68', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVzVOYmtab205ZUFKaU9vOXdDenQ4bjdRTFZsa3Q1WElHT1Z4cW9vRSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTY6Imh0dHBzOi8vd3d3LnRlcnJhLnJ3L2Rlc2lnbnMvcHVyY2hhc2UvNS1yb29tcy0xNzczOTE2MjY4IjtzOjU6InJvdXRlIjtzOjI1OiJmcm9udC5idXkuZGVzaWduLnB1cmNoYXNlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774790909),
('8VV8LlPebvJF5rLkKskDfJMAS3qFZ9LVc7AQJxML', NULL, '194.163.180.153', 'Python/3.11 aiohttp/3.9.2', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoienpnYkhyT1RHMDdqYjBMSnlPeUQ0RzhOaG1remFyVnlpZHBvUjVKbCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHBzOi8vdGVycmEucnciO3M6NToicm91dGUiO3M6MTA6ImZyb250LmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774793355),
('aHIY44vEe5ixRVcsIwMHpO7sWXHstZAjBXZ7L3TJ', NULL, '43.173.180.22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid2pPQm5zM3YwcnZ5WGdpT1Z6M2tNdUhqTERpak9haUNrNHVRa0ZZMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly93d3cudGVycmEucncvYWRkL3Byb3BlcnR5L2FyY2hpdGVjdHVyYWwiO3M6NToicm91dGUiO3M6MjM6ImZyb250LmFkZC5wcm9wZXJ0eS5hcmNoIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774786946),
('bP6JxaZHdeFkbyQ1q7CaDWY09j6OJxr6qZhsGwfB', NULL, '194.163.180.153', 'Python/3.11 aiohttp/3.9.2', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidngxN2FlR3RpY2k0clU5dXRlMW1oa2JNUXdEdW9CUllFd0NRcUpWcCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHBzOi8vdGVycmEucnciO3M6NToicm91dGUiO3M6MTA6ImZyb250LmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774787952),
('cfTFh1qF1Wec2GURf6ec2cAaIxeBrZlqdFTb7TD2', NULL, '207.46.13.107', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaWJySU5iSDVhZlVrN3NoWmF1M3hZZ1FvSjlveDFDRTdvQXIyaWhGYSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vd3d3LnRlcnJhLnJ3L3JlZ2lzdGVyL2NvbnN1bHRhbnQiO3M6NToicm91dGUiO3M6MTk6ImNvbnN1bHRhbnQucmVnaXN0ZXIiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774777876),
('DgV9XO5LRmsUaCYMz2ZQKeiHTiowSIIUIVTG1dYh', NULL, '194.163.180.153', 'Python/3.11 aiohttp/3.9.2', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZERPb05ZbnBRazBja2s3ZTNVQmo2WktacGxDcTBqN3Q3OVdCNmF1OSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHBzOi8vdGVycmEucnciO3M6NToicm91dGUiO3M6MTA6ImZyb250LmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774782568),
('dSlyDo56zHO8OjiEfFisLJ8fOlgGpkRE9UpktPaY', NULL, '207.46.13.107', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMDRHSXJxWjFsTDduNlpEdDJSdlpkT2tlcDV2UjloeWVyQlU4NkNWcyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vd3d3LnRlcnJhLnJ3L2J1eS9ob21lcy83IjtzOjU6InJvdXRlIjtzOjIyOiJmcm9udC5idXkuaG9tZS5kZXRhaWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774791209),
('EoCzNW9bIRjeuRGYUU89W3pP3QD2dUl0jJlpSmBO', NULL, '43.173.180.206', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRVhUUXRnbWpLVWZ5dEtvdGxQOTRkZTR2eWkyNUFOakNNcUZTNGhmbiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vd3d3LnRlcnJhLnJ3L2J1eS9sYW5kcy8zIjtzOjU6InJvdXRlIjtzOjIyOiJmcm9udC5idXkubGFuZC5kZXRhaWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774782030),
('eYEWO6tKpyTYjNaXMDW1597wmMmpDYRfYPFnVicX', NULL, '43.172.197.37', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTmpjR1AxbFF4REF3ZnVpMVhNOWJJZklVb09WSDQ3RnI4Zm14UDNQTiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly93d3cudGVycmEucncvYXBhcnRtZW50cy9yZW50IjtzOjU6InJvdXRlIjtzOjIxOiJmcm9udC5yZW50LmFwYXJ0bWVudHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774783181),
('F4lWmvp0ZKrgLhetsBwSwVNTMQj2vb0US9WoUUxS', NULL, '157.55.39.49', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSWtOMUxURnc5UVBGOTBpcUtnRHd0RHJ4OU9XRHBGNDBzdExORDc0UiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vd3d3LnRlcnJhLnJ3L2NvbnN1bHRhbnRzIjtzOjU6InJvdXRlIjtzOjIzOiJmcm9udC5jb25zdWx0YW50cy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774780151),
('F5En0mEXnVPQsX6LO5ouSpw52SalPWWfm6HCvqOG', NULL, '194.163.180.153', 'Python/3.11 aiohttp/3.9.2', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTDl4TjNCQ2Z0Zm9MUDdQdlk1anBiakJ2MXROWVluNUhFN2Z0OXk2MCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHBzOi8vdGVycmEucnciO3M6NToicm91dGUiO3M6MTA6ImZyb250LmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774777148),
('fyT6kTSZnR1vk75SYSootwpChieVwrtoPIdnFqxX', NULL, '207.46.13.153', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTEVkbmVHWHFqMTJTeDExZGwxMmpXczZ6MnJ6anY1NkVnbEJEWW5uWCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vdGVycmEucncvcmVnaXN0ZXIvY29uc3VsdGFudCI7czo1OiJyb3V0ZSI7czoxOToiY29uc3VsdGFudC5yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774791273),
('gfe7UqZaeDgAxnUyTaqxorP2k7XcIOUrctBWl0Io', NULL, '43.172.198.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSFBzZFVxMVNMUTVnbzNNbGc0Q0dmWDBtdzNHMTduTEdoWlRzOFA5cSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vd3d3LnRlcnJhLnJ3L2J1eS9ob21lcy8xNSI7czo1OiJyb3V0ZSI7czoyMjoiZnJvbnQuYnV5LmhvbWUuZGV0YWlscyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774792737),
('hLacyCyvFn7mlWkv1lWSAkQvLJgfqAbtiWO4H0zu', NULL, '100.26.155.241', 'Mozilla/5.0 (Linux; Android 7.0; LGUS997 Build/NRD90U) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.125 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidDV1UzBwaUIydlNiZHNqTTBiQVJ4U3YwdDUyTDVUaDR3akVFQXVuTyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTU6Imh0dHA6Ly90ZXJyYS5ydyI7czo1OiJyb3V0ZSI7czoxMDoiZnJvbnQuaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774791782),
('hy0IHgibvz43W1AQMl4HhTTeKMT0ItBdHalxd3IW', NULL, '43.173.173.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRUk2b0ZPZjFyQUN0VGllRUFQcklvN1dnUmgwVVVNUlhxSzE4ZDlJcSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly93d3cudGVycmEucncvYWdlbnRzIjtzOjU6InJvdXRlIjtzOjEyOiJmcm9udC5hZ2VudHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774783126),
('I1DcSxUy34pIQxpU2pNi9blaDgPNeOrTvnm8u1at', NULL, '41.186.138.57', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSmprSXZWa2JHaXF0emo2N1FjVElnc0M4RGxQNE1xdE1XbWJ0bUpvSSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly93d3cudGVycmEucncvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1774782717),
('Jg2OZwbk6iaP5Glx3bch7mCihhbEZzmD4PAfSXAb', NULL, '43.173.178.209', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV01XUng0TG40UlBFaUpzYjVRUEFhVEswUERrYlJqcGZZNlFhR1NDYyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly93d3cudGVycmEucncvYnV5L2hvbWVzLzE2IjtzOjU6InJvdXRlIjtzOjIyOiJmcm9udC5idXkuaG9tZS5kZXRhaWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774777791),
('jIoRFeoVxOcpj31F5vPxDwncwr9KXPAaHm8MkbDV', NULL, '207.46.13.92', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiekc0cHZxRm5pdndzcVFFUmVLSGE2OWljNmF5cUdFY0ZHRWlPdWNLcSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vdGVycmEucncvYWRkL3Byb3BlcnR5L2xhbmQiO3M6NToicm91dGUiO3M6MjM6ImZyb250LmFkZC5wcm9wZXJ0eS5sYW5kIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774781054),
('jJ1C74lTu8j534t9W31hedBkpfylVNj07Oz27yyD', NULL, '43.172.196.94', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibTdRbmdRTXpmOTFYMlllSWhLQWxCWVJ6SUNaYmYzWFNRbTVjOUlhbiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly93d3cudGVycmEucncvYnV5L2xhbmRzLzQiO3M6NToicm91dGUiO3M6MjI6ImZyb250LmJ1eS5sYW5kLmRldGFpbHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774788770),
('Jwp4zkku0VrG6Zsv7Mg5JkwRne0iN4URLgYs1QAX', NULL, '54.162.171.193', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.54 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNENhVGVIWDFwd1EzTTF3QUZ4clVCcktFSmhLcEZmTzRBVVNxOFZTTCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vd3d3LnRlcnJhLnJ3IjtzOjU6InJvdXRlIjtzOjEwOiJmcm9udC5ob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774776981),
('Kg69Pv05mmS0gciDOiPrSsZ8U98o1pbv8SwciBe8', NULL, '194.163.180.153', 'Python/3.11 aiohttp/3.9.2', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN255aXdNbUs2TlJjVFBDaFpIWldyQWJtaEEyOVZQRzF2b3pTWEx0SSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHBzOi8vdGVycmEucnciO3M6NToicm91dGUiO3M6MTA6ImZyb250LmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774778959),
('KvFJqhzxKqLGZlUncjtW68AfFlLb65Q1esYBboVu', NULL, '157.55.39.195', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUW1jUldqOXFUYlVEY2M2VGF0SGZiTUdNbTY2VG95ODN6cXhGQkxNSCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vd3d3LnRlcnJhLnJ3L3Byb3BlcnRpZXMvS2lnYWxpIjtzOjU6InJvdXRlIjtzOjIyOiJwcm9wZXJ0aWVzLmJ5LnByb3ZpbmNlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774778819),
('lFlYgMZqji0uBkDhqtEvNbmAlpfSuJtGbrZoEVkz', NULL, '107.20.68.138', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib1lYR1ZVZ3JUTVpWaVJDZFRlcXJHdm5ONnlKbkFKT3lXRVZ2eHMwdSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vd3d3LnRlcnJhLnJ3IjtzOjU6InJvdXRlIjtzOjEwOiJmcm9udC5ob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774782662),
('LKb1vKZD9BrZcA2aaMCNsJGNXl9cVfKI7dOPUpOa', NULL, '194.163.180.153', 'Python/3.11 aiohttp/3.9.2', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUVlvbXEwSzd0RFhYWUJ4S0NoTUNUOUVkR1FEM05vT3dITFRFU1Y2VSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHBzOi8vdGVycmEucnciO3M6NToicm91dGUiO3M6MTA6ImZyb250LmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774795159),
('MiriE1eGwADBsrOgpCeM7ngNOYh72Nrn9oY0lqg0', NULL, '194.163.180.153', 'Python/3.11 aiohttp/3.9.2', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRThubEIzbVlNZTh6Y2YwUE9CTWRRRTRxQXNIMkx6ZmlFVjNSZ2dLcyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHBzOi8vdGVycmEucnciO3M6NToicm91dGUiO3M6MTA6ImZyb250LmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774786151),
('MtpJozUJR7D34cJJ0nkEFPgrPliC0RwCsy9jcOUy', NULL, '18.207.232.202', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQW5XZHRrd1dsbW1pOG1UcTRoU0JyV2dhQVlYR0l0QnFjUkpFR2p6WiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHBzOi8vdGVycmEucnciO3M6NToicm91dGUiO3M6MTA6ImZyb250LmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774782662),
('nlzrvjLesBOy7Kv3cSNKNknbIl0ubPs1fDcoMmEb', NULL, '100.26.155.241', 'Mozilla/5.0 (X11; Linux i686; rv:12.0) Gecko/20120502 Firefox/12.0 SeaMonkey/2.9.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMlkxVUh4RkRsN0Z2elZFTXU4WFpNTGlKWFJFWkZ2RUhNOE1pSjFmaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHBzOi8vdGVycmEucnciO3M6NToicm91dGUiO3M6MTA6ImZyb250LmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774791782),
('nLzW7bejRoSsLvnqPshfgeFQz29ds5Ekiass8fy4', NULL, '43.173.179.147', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNVBvVERHTmdIYURKV3B0aHdveFk4d091ZWFDcWtsMDB0STVlVDFXTyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTY6Imh0dHBzOi8vd3d3LnRlcnJhLnJ3L2Rlc2lnbnMvcHVyY2hhc2UvNS1yb29tcy0xNzczOTE2MjU5IjtzOjU6InJvdXRlIjtzOjI1OiJmcm9udC5idXkuZGVzaWduLnB1cmNoYXNlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774786947),
('nTkOA3n90CZBNozlue4GTuX5Kn0oV6d9JyztYYGF', NULL, '43.173.179.161', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRnVkRG9lem40cDBld1MzRUZKUzJJbE1Fc2M4MUxKY21ialR6WWFhZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly93d3cudGVycmEucncvZ2V0L2FkdmVydGlzZW1lbnRzIjtzOjU6InJvdXRlIjtzOjE1OiJmcm9udC5hZHMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774796273),
('nuo3MqhYlsih5EhBUto7kkG28LLPKxm4DHoh5pY6', NULL, '100.31.64.169', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRUVQQjB6WTFISHN3ZDlhUnJnT3FYOG5RQ09VN244d3JzdEVGREpQdiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHBzOi8vdGVycmEucnciO3M6NToicm91dGUiO3M6MTA6ImZyb250LmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774776980),
('OCM3pBJgOI5QL7CcutTod0scdQ09e1Cds7Z4J8Bz', NULL, '43.173.178.171', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.3', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUXhtR2JUUGZ1ajJGejVoTlJhNTFwN2dmUktkWkN2SXlXZkNZbUo0SyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDY6Imh0dHBzOi8vd3d3LnRlcnJhLnJ3L2Rlc2lnbnMvbW9kZXJuLTE3NzM5MTU4NzEiO3M6NToicm91dGUiO3M6MjE6ImZyb250LmJ1eS5kZXNpZ24uc2hvdyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774796339),
('ODmIJy1NUxLy0ySTyzApN8QUywnqFN0Fdvvb6S3C', NULL, '194.163.180.153', 'Python/3.11 aiohttp/3.9.2', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTTNRdnhyeHR6S2NUbjNZajRLU1VON0FwSlJSNDJZVHM2NkZydVpEUCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHBzOi8vdGVycmEucnciO3M6NToicm91dGUiO3M6MTA6ImZyb250LmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774780777),
('of2Ek61ji5LHnWkShc1sOlnUtXwJaI6U58bOH0mT', NULL, '194.163.180.153', 'Python/3.11 aiohttp/3.9.2', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib3lSMDZHSjMwa0pRbTlwRlQydHhpbXdJS3FoZm1ZZGk4MTRqaXB3UiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHBzOi8vdGVycmEucnciO3M6NToicm91dGUiO3M6MTA6ImZyb250LmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774789753),
('PnGrNHbRzXslHnhFJsJGQ5rntDSdaPrlyJRoEItK', NULL, '100.26.155.241', 'Mozilla/5.0 (Linux; U; Android 4.0.3; de-de; Galaxy S II Build/GRJ22) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVFozWHNKSlJ6VTFZNGszakZKenNha1pTVzN6RDY0eDB5UThmUFZ5RyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTU6Imh0dHA6Ly90ZXJyYS5ydyI7czo1OiJyb3V0ZSI7czoxMDoiZnJvbnQuaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774791782),
('rURlofTc0Nv8pxyRBl3WmKlqWntwErtpNx1VTjE8', NULL, '149.57.180.121', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTG1HSHF0UHJvWmRzVG80RXhtd0hka2tIZUJlN0VYcDR2aDFkZDZCcyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHBzOi8vdGVycmEucnciO3M6NToicm91dGUiO3M6MTA6ImZyb250LmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774782377),
('sd63nRMr66wXM6N2JtfUvMzSI2l9Hkb1rzshIoTg', NULL, '43.172.196.187', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQTJIdnJYZEVZWUJTTUZudVNLbFpncnFCTnZwb2VSUXJzY0luQzRtOCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vd3d3LnRlcnJhLnJ3L2dldC9zZXJ2aWNlLzQiO3M6NToicm91dGUiO3M6MTc6InNlcnZpY2VzLmNhdGVnb3J5Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774783246),
('ShkFR5zd000eRcD4t9sgAjln1VvllqRrSPgAuoBy', NULL, '40.77.167.76', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic0llZGgyMk5MMHV5Z2tUMHhrQllpU1FydmNVQ1lmTjZramlMY21qNSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vd3d3LnRlcnJhLnJ3L3JlbnQvbmVhci1tZSI7czo1OiJyb3V0ZSI7czoxOToicmVudC5zZWFyY2gubmVhci5tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774798185),
('SJUM7dDtfJGDQvatWAjoxYmpa9C6kgmfnXGxX6Oc', NULL, '173.252.87.34', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMGhLZ3duWUczRFU4Q093QTFndUtQNVh5YUJsV2dpWmNWSlF6bjYxSyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY0OiJodHRwOi8vdGVycmEucncvP2ZiY2xpZD1Jd1pYaDBiZ05oWlcwQ01URUFjM0owWXdaaGNIQmZhV1FNTWpVMk1qZ3hNRFF3TlRVNEFBRWVVTDlfcW91bm1ZWXVsdHVOSFFCQWlWUm1QNE5uMTlFZzZQTjdQWFgzRHQ2R0NUYXlXdnMwVFBzYlhnWV9hZW1fTElCaFlkUmNqZ2ZYeVdydzZfSjFSdyI7czo1OiJyb3V0ZSI7czoxMDoiZnJvbnQuaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774796748),
('SNV3F44cZotPiCoRO5tOi4tHTPY3sWPQSXqnhyIG', NULL, '43.173.175.61', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMjNTWmo0MWFmTUR6V0pNeE42cEQ0TFJkd0R3RkJUWFU3a2FLVXlEZiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vd3d3LnRlcnJhLnJ3L2J1eS9sYW5kcy8yIjtzOjU6InJvdXRlIjtzOjIyOiJmcm9udC5idXkubGFuZC5kZXRhaWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774790721),
('SPUSiTqS36T5YErWVN9i0GLDf4FhIaZR14rjRAtB', NULL, '194.163.180.153', 'Python/3.11 aiohttp/3.9.2', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieDBFNlNtRmo5eFJUbGw1MENsVHZWRXBqYkprcWZ2ckhlUlpnODV4TiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHBzOi8vdGVycmEucnciO3M6NToicm91dGUiO3M6MTA6ImZyb250LmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774784358),
('sQPyipgic2pAG7BvXcdfOA245Zle1RR4u7RNEqwC', NULL, '43.173.182.116', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWmswa1VsMVlzQWNNZjhXYTA5ZzRXUWxRNmJYdUZoWExZRWJOMlQ3aiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHBzOi8vd3d3LnRlcnJhLnJ3L2Rlc2lnbnMvNmJlZHJvbS0xNzczOTE2MDkxIjtzOjU6InJvdXRlIjtzOjIxOiJmcm9udC5idXkuZGVzaWduLnNob3ciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774783062),
('sYGrw0CU08jxaa2uYcyH8d9GvnGK9VOWS8RHQnO0', NULL, '178.79.137.187', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.14; rv:70.0) Gecko/20100101 Firefox/70.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUWI5cDQyUEpwU2NzQzZBd2gzdzl5STJjSWFBUmVUUnFuMFJVTkk3SyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTU6Imh0dHA6Ly90ZXJyYS5ydyI7czo1OiJyb3V0ZSI7czoxMDoiZnJvbnQuaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774790322),
('u4KGxtsYZYoVOKICXpIExxIMXTVX7nx9IA2Nbkcm', NULL, '41.186.135.252', 'WhatsApp/2.23.20.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid0x5cXBRNGR4QndlUlFhR1hVRkNpaHR6eWVKVXpscEVsWnR0Snp3YyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vd3d3LnRlcnJhLnJ3IjtzOjU6InJvdXRlIjtzOjEwOiJmcm9udC5ob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774776129),
('UUu28wzbG3kH2g656Rz0b9U878JAkOnDpDqXAVqG', NULL, '40.77.167.49', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNGpKSUcyejJ3cWJPeThqY2JVdEhXYWhic2tmTWMxVldWaU1OUVZyUyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vd3d3LnRlcnJhLnJ3L3Byb3BlcnR5L3JlbnQiO3M6NToicm91dGUiO3M6MTY6ImZyb250LnJlbnQuaG9tZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774778152),
('vDJiL0NbAqnXDv4fSGbRkMlvFNfbIRcbqOhbuMxH', NULL, '43.172.197.33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVnZmWDZmVWE5SFNHUERnY25lZ1dYSGVvSTl5VXcwSzhBR0h1OW9VVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHBzOi8vd3d3LnRlcnJhLnJ3L2Rlc2lnbnMvNS1yb29tcy0xNzczOTE2MjY4IjtzOjU6InJvdXRlIjtzOjIxOiJmcm9udC5idXkuZGVzaWduLnNob3ciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774796339),
('vj9ds7xzAVOqkFP3gGfC8uJ2XC482MeXZNROTrO2', NULL, '43.173.181.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.5112.81 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNzNlSXRxc08wVEVOcHFMVzdpeDNzWFQ3VUdZeERaTHNtWURTenM5TSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly93d3cudGVycmEucncvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774792738),
('VyelsBwFHSfa2dIjQptBW4VLlin3tr9RTIwGOiFy', NULL, '194.163.180.153', 'Python/3.11 aiohttp/3.9.2', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNmR2Mm02N1hkOGRTVVdUdU9zWkg4VWlxU05wSDBabUZ2RkF0MGxjciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHBzOi8vdGVycmEucnciO3M6NToicm91dGUiO3M6MTA6ImZyb250LmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774798751),
('WanU7aLaDMHkNQZzDhqIyri4XD08bzorGjTGes5c', NULL, '207.46.13.52', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSjRMSTdSeVhxMGhPdFlNaVVvaHVhUldBcFQzRHpzczdsanAyWWpZdyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vd3d3LnRlcnJhLnJ3L2J1eS9sYW5kcy8yIjtzOjU6InJvdXRlIjtzOjIyOiJmcm9udC5idXkubGFuZC5kZXRhaWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774779188),
('xjYgnGtJYxcAHRT3GavIu42dqXl36empWnr3jTJc', NULL, '207.46.13.126', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoialZIMjRXTVJjOGFmZXFSQmNHTUtuQmZqejhPZXdwNkJjV2M3TTBYaiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vd3d3LnRlcnJhLnJ3L2NvbnN1bHRhbnRzIjtzOjU6InJvdXRlIjtzOjIzOiJmcm9udC5jb25zdWx0YW50cy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774798989),
('XOBI3otZv8zQI23BmVHDYSCNxG5exheBtWk8iW0u', NULL, '43.173.178.175', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibWtCSUI4ckNxdmdPUjBZQVlSVEFscUlvNjJnYmIwOUJHdUJVNzZXOSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly93d3cudGVycmEucncvYnV5L2xhbmRzLzYiO3M6NToicm91dGUiO3M6MjI6ImZyb250LmJ1eS5sYW5kLmRldGFpbHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774796272),
('XOYjftre8IKcrZ7i8OHfCEWWgOc868gsO6nRGStE', NULL, '157.55.39.195', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWmRKbjE3QnZsRGJYSFVPU0l5dWhuSVQ3b3lTVWNocGtTczNiUDRISiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vd3d3LnRlcnJhLnJ3L2J1eS9sYW5kcy80IjtzOjU6InJvdXRlIjtzOjIyOiJmcm9udC5idXkubGFuZC5kZXRhaWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774791293),
('xXDwkAIgXWxCye3bgE9bmMAvRDFPvLWVma3DxSOa', NULL, '194.163.180.153', 'Python/3.11 aiohttp/3.9.2', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaWxYOEdCZWhqNmY0WnlwdmdFcldLWFVQVGxneGl5YndrNm11ZGdMMyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHBzOi8vdGVycmEucnciO3M6NToicm91dGUiO3M6MTA6ImZyb250LmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774796953),
('Y2CYpC7ZTkdjE1KDif955NQKJfrYrlfClAG6dZaH', NULL, '43.173.179.251', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU3paU3ZwM2RIY3RFTzBRWE9jZGY1cGNIZ2RGOUVhS0d6Rm94T3ZSdyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly93d3cudGVycmEucncvYnV5L2hvbWVzLzE1IjtzOjU6InJvdXRlIjtzOjIyOiJmcm9udC5idXkuaG9tZS5kZXRhaWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774790920),
('YAtPGidOMyhJ11QM2ftzBHAqfRuktsQ9fCmepPOg', NULL, '43.173.178.107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY0tUbE4yVnZ6d2ViRnI2N2VFNEZZNzBrUGZseW9xdHVyVVp6dnYxWCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly93d3cudGVycmEucncvYnV5L2xhbmRzLzEiO3M6NToicm91dGUiO3M6MjI6ImZyb250LmJ1eS5sYW5kLmRldGFpbHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774790665),
('Yyp3hGzhh4Z0A0Jz4RQpRj1m4Noz0QxRZsDlSvcW', NULL, '43.173.178.208', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRTFKRWJENVRkRzh3cHJlOEJHMGR1UzZjTXdTNXlRckpFT2dnM1ViZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly93d3cudGVycmEucncvYnV5L2hvbWVzLzE1IjtzOjU6InJvdXRlIjtzOjIyOiJmcm9udC5idXkuaG9tZS5kZXRhaWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774790909),
('ZXztjKTPpupUCLLzeaLZkdFFjqv0kptrrODgHmzp', NULL, '69.63.184.48', 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVmJwYUhnaXYzTnUwOU9QU1M5b3E0YjBVNzZkVEFhaE1XVDlhZ2pKcyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY0OiJodHRwOi8vdGVycmEucncvP2ZiY2xpZD1Jd1pYaDBiZ05oWlcwQ01URUFjM0owWXdaaGNIQmZhV1FNTWpVMk1qZ3hNRFF3TlRVNEFBRWVVTDlfcW91bm1ZWXVsdHVOSFFCQWlWUm1QNE5uMTlFZzZQTjdQWFgzRHQ2R0NUYXlXdnMwVFBzYlhnWV9hZW1fTElCaFlkUmNqZ2ZYeVdydzZfSjFSdyI7czo1OiJyb3V0ZSI7czoxMDoiZnJvbnQuaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774796785);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `employee_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive','suspended') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `joined_at` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tenders`
--

CREATE TABLE `tenders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `budget` decimal(14,2) DEFAULT NULL,
  `submission_deadline` date NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_open` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terra_jobs`
--

CREATE TABLE `terra_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `type` enum('full-time','part-time','contract') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'full-time',
  `deadline` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terra_job_applications`
--

CREATE TABLE `terra_job_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `cv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_letter` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','reviewed','accepted','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('user','agent','professional','consultant','admin','staff') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `is_verified` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `is_verified`) VALUES
(1, 'Admin User', 'admin@terra.rw', '2026-03-14 13:46:15', '$2y$12$vQ1G1OTD/Frvw5MSryLzXe1LLq084YrGwZcqeytHlVJLC/BWbPhAS', '2LC11CsfDXyjWoAjS4XxB8AuwtJMWd6XRF9bGfdidc5WESJYeoHkfCTVo8Rb', '2026-03-14 13:46:15', '2026-03-14 13:46:15', 'admin', 0),
(2, 'Jean Claude', 'jean.agent@terrarealestate.rw', '2026-03-14 13:46:15', '$2y$12$eFFzvcNMkaF71u0gYtzXZuXAav/3L4WC7hYhG4NIPwshcxggN1nHy', 'lkHNQT6CEu', '2026-03-14 13:46:16', '2026-03-14 13:46:16', 'agent', 0),
(3, 'Diane Uwimana', 'diane.agent@terrarealestate.rw', '2026-03-14 13:46:16', '$2y$12$tH8yKOhy5JXsg0LnPlUlzOx4D/1frvr.gHHnqnYAnGMgegluZQGRG', 'M4zKDEzRtM', '2026-03-14 13:46:16', '2026-03-14 13:46:16', 'agent', 0),
(4, 'Eric Mugisha', 'eric.user@terrarealestate.rw', '2026-03-14 13:46:16', '$2y$12$vu.lUE3IjoSS7VEv8SUdd.sJjDjxWmryyoHGYyEVSh.yNkH2XjyLG', '59cQpTYrHX', '2026-03-14 13:46:16', '2026-03-14 13:46:16', 'user', 0),
(5, 'Claudine Mukamana', 'claudine.user@terrarealestate.rw', '2026-03-14 13:46:16', '$2y$12$qHbkUW0yyBMdtyFpxBBpbeSApgYCf/2M.V.cpdD1WJABolfLwqah2', 'wMPd2cL1uP', '2026-03-14 13:46:17', '2026-03-14 13:46:17', 'user', 0),
(6, 'Patrick Ndayishimiye', 'patrick.user@terrarealestate.rw', '2026-03-14 13:46:17', '$2y$12$jvGKZVRp6YehGAqoNhrCUeDOIxUV.c8P5s0fa2hJIs/jrQP0c783m', 'ufb97SgFCo', '2026-03-14 13:46:17', '2026-03-14 13:46:17', 'user', 0),
(7, 'Claudine Uwimana', 'claudine.uwimana@imari.rw', '2026-03-14 13:46:18', '$2y$12$LF29x3v/mMaUe.vBq8IF9.3cfZOY8duIFMzhBjyVN//klGiVN3czW', 'W0Wq7XJ6IlD3W1UwIoGOlOrTeST49VvkIEaNeuWvSG53x27VWXs2Q1riSAMH', '2026-03-14 13:46:21', '2026-03-14 13:46:21', 'user', 0),
(8, 'Jean-Pierre Habimana', 'jp.habimana@imari.rw', '2026-03-14 13:46:18', '$2y$12$J1gZJf7a7eMfmJlPe8wtB.z4EB5/CIi22JWJ4uGVV9pxQ.XWNF3rO', NULL, '2026-03-14 13:46:21', '2026-03-14 13:46:21', 'user', 0),
(9, 'Aline Murekatete', 'aline.murekatete@imari.rw', '2026-03-14 13:46:19', '$2y$12$Q.pZQe32W5pRXs9nxCpJwupTS0.35.pevUBCOiLhSz/VMnHKMFEhO', NULL, '2026-03-14 13:46:21', '2026-03-14 13:46:21', 'user', 0),
(10, 'Patrick Nshimiyimana', 'patrick.nshimiyimana@imari.rw', '2026-03-14 13:46:19', '$2y$12$uxlZvlgsI/Y484fCazv7/eq64ofhES06YjaAuXBI1qSUAiJ2AE8MW', NULL, '2026-03-14 13:46:21', '2026-03-14 13:46:21', 'user', 0),
(11, 'Solange Ineza', 'solange.ineza@imari.rw', '2026-03-14 13:46:19', '$2y$12$lUopB2cB8Y2HuVuPzQ62juL2lWgXrzEdnXhm/hqMVEVcLb3lp.ax6', NULL, '2026-03-14 13:46:21', '2026-03-14 13:46:21', 'user', 0),
(12, 'Emmanuel Mugabo', 'e.mugabo@imari.rw', '2026-03-14 13:46:19', '$2y$12$h/MpGTDcu669ro2e4wFWm.UI.Gt6qhre0rKQ/HpbQ/tLcXBuCsljy', NULL, '2026-03-14 13:46:21', '2026-03-14 13:46:21', 'user', 0),
(13, 'Diane Ishimwe', 'diane.ishimwe@imari.rw', '2026-03-14 13:46:20', '$2y$12$DPZBMF/WQeqRHrfaVKPKXOl5ZJ8MtJHWZ6n0xaMSPDQ4YjkUcnWfK', NULL, '2026-03-14 13:46:21', '2026-03-14 13:46:21', 'user', 0),
(14, 'Thierry Nsengiyumva', 'thierry.nsengiyumva@imari.rw', '2026-03-14 13:46:20', '$2y$12$WoaNUdhraPPXAaobCYegrOKM2rqcRRerWvhRS.uRvf8RE0z7jUtZ2', NULL, '2026-03-14 13:46:21', '2026-03-14 13:46:21', 'user', 0),
(15, 'Grace Akimana', 'grace.akimana@imari.rw', '2026-03-14 13:46:20', '$2y$12$7840LOoTedyfm6p77vFwNutoALI9P9HAKsrH0NkzWlyVrnkjFodg6', NULL, '2026-03-14 13:46:21', '2026-03-14 13:46:21', 'user', 0),
(16, 'Bosco Niyonzima', 'bosco.niyonzima@imari.rw', '2026-03-14 13:46:21', '$2y$12$NGFxZQnruIo3zyn7LVKECuuMPV9L5q62korqBR5BZEgOurAxRz.Iq', NULL, '2026-03-14 13:46:21', '2026-03-14 13:46:21', 'user', 0),
(41, 'misago florien', 'misagoflorien@gmail.com', NULL, '$2y$12$qgyGEcTijjnuhZGC/Lc8eetDeNVaWPh.HQh.ZXo0/.2M74dFrutBG', '7yLhbXTMpnDjIFFwsYZNdKLguxERTuDirqMZBICr6l3UvLHUfiVbzGn80e9a', '2026-03-18 10:05:15', '2026-03-27 08:00:56', 'admin', 0),
(47, 'Lucky Mutesi', 'tesylucky@gmail.com', NULL, '$2y$12$aUGgykz646UoN8bwpGrUlehsz9UKyAZTBidOYfoV165LCjOF67GR6', NULL, '2026-03-18 11:01:37', '2026-03-18 11:01:37', 'agent', 1),
(49, 'Eric Mugisha', 'keric@gmail.com', NULL, '$2y$12$MuDlS9.THsZaq5SzNmumkuIbxL7BcgDxf3NPX8SR8ltNgUiOqV8uq', NULL, '2026-03-18 11:50:09', '2026-03-18 11:50:09', 'agent', 1),
(51, 'Eric Mugisha', 'kabosieric@gmail.com', NULL, '$2y$12$d3NPQkK159lu6I.tZjSRreJzsz6cLgJH.XaeAKEMFjsYTt.Oi4r8i', NULL, '2026-03-18 11:52:03', '2026-03-18 11:52:03', 'agent', 1),
(52, 'Lucky Mutesi', 'aganzeblakely@gmail.com', NULL, '$2y$12$UQG/5sARduzxcPldgTf5/OuB8b2PvWFCcwJ7X6IaVy88RTc6pzsAe', NULL, '2026-03-19 06:15:18', '2026-03-19 06:15:18', 'agent', 1),
(56, 'Amina uwimana', 'you@gmail.com', NULL, '$2y$12$iPcWTQWXypkKQpS.8M9HZOr9EMJ34mGCA4ql9nI52UzXRpDCWLJtW', NULL, '2026-03-19 06:40:11', '2026-03-19 06:40:11', 'user', 0),
(57, 'Ineza claire', 'inezaclaire@gmail.com', NULL, '$2y$12$a9c18U4YZEj.Nz0ZnbAZPe6TVt7N3lxBa5khdc6/Oi8DN/HU65CMO', NULL, '2026-03-19 06:44:31', '2026-03-19 06:44:31', 'user', 0),
(58, 'mugisha eric', 'info@homiez.rw', NULL, '$2y$12$N4/Fcq.ogWwaxRDFp/souuksGYCyDFEmppxR7iQcjD4xl.Cw7NDz.', NULL, '2026-03-19 07:45:04', '2026-03-19 07:45:04', 'user', 0),
(59, 'alice uwimana', 'uwimana@gmail.com', NULL, '$2y$12$NYUDsBfwvz/8ZhKvH0G1FOp5Asnqa01rrAbXPOx546HtzgIzxEI7u', NULL, '2026-03-19 08:23:33', '2026-03-19 08:23:33', 'user', 0),
(60, 'Nyiraneza Jacqueline', 'jackyn@gmail.com', NULL, '$2y$12$/ri1RvOs4PVIyLnvGRsAKe7JolV9HqimilaZP1t5QOWRxH08iO6TG', NULL, '2026-03-19 08:38:53', '2026-03-19 08:38:53', 'agent', 1),
(61, 'Jacky M', 'jackyneza@gmail.com', NULL, '$2y$12$tE/D5TjMbOsYtS81hq6b1Oh1ouo0mzAy37iexA1z.geiMhVtQ7CFK', NULL, '2026-03-19 08:44:24', '2026-03-19 08:44:24', 'admin', 0),
(62, 'david', 'david13@gmail.com', NULL, '$2y$12$K1GZko1PLJMlm3scUujZEuB46QC6hdSiyaGJSSALR.a8zxTeIlzR2', NULL, '2026-03-19 09:17:01', '2026-03-19 09:17:01', 'admin', 0),
(63, 'Keza Ornella', 'kezaornella@gmai.com', NULL, '$2y$12$kI6kE.m9cfxqIV4Be/CZjOuIfQEyq3xYmhndVonJWMVn4xYYW0/ui', NULL, '2026-03-19 09:25:57', '2026-03-19 09:25:57', 'agent', 1),
(64, 'Joan', 'example@gmail.com', NULL, '$2y$12$iaKaicbWZQpIXr3BCZSeUuICKgf6T5Zuo9skFJFaKyh8s4F48IdhO', NULL, '2026-03-19 09:33:44', '2026-03-19 09:33:44', 'admin', 0),
(65, 'Test', 'test2@gmail.com', NULL, '$2y$12$Bs9.2e2WidqdGHjvEPE7ruekLPoRQGUA5womWhMluvB0jECE85/yi', NULL, '2026-03-20 06:58:38', '2026-03-20 06:58:38', 'user', 0),
(67, 'Mugisha Eric', 'agentmugisha@gmail.com', NULL, '$2y$12$3EI2pfI6aVlo7F.6ZjOWSeQ/a9NYz5vd6EfpMeusosT4ab0by8i6q', NULL, '2026-03-23 06:07:16', '2026-03-23 06:07:16', 'agent', 1),
(68, 'Mugisha Eric', 'ugisha@gmail.com', NULL, '$2y$12$hmCC/S/fDkWGJszD8zLyY.3gMKa0gX0OaB7LmevD.//u71XkoJgqS', NULL, '2026-03-23 06:10:50', '2026-03-23 06:10:50', 'agent', 1),
(75, 'Nzungize jean Damour', 'jeandamournzungize5@gmail.com', NULL, '$2y$12$N7Ji58RdsqxHOYMFde7Atewbby3CwsmicligbaqoN5YOKsNojvDw6', NULL, '2026-03-23 07:51:38', '2026-03-23 07:51:38', 'user', 0),
(85, 'Test', 'test@test.com', NULL, '$2y$12$8u0bPczXygwO8IjISnB61uDt88x/npRIZtQmlTr1WN/GIt/o.OGN6', NULL, '2026-03-25 08:03:08', '2026-03-25 08:03:08', 'user', 0),
(86, 'TWAGIRUMUKIZA', 'twagirumukizaeugene203@gmail.com', NULL, '$2y$12$ZX3LnU89NIPsLFylnQbWzOyM7OophSLRMz31hyCh8u6WqVt0JSJ3O', 'GWWrhZuP2sa1CHVzgNQXRUsjsQQ12PWe5z0uEHoRK5eGQKuHtinNqr5b4Ota', '2026-03-25 08:19:38', '2026-03-25 08:19:38', 'user', 0),
(89, 'KAYONGA Erasme', 'erasmus1030@gmail.com', NULL, '$2y$12$vMKlVOn.WPr9pIXyzZ5wIugpL9CNbJVkc4Ivkjo.j9wKLRXY4jQDW', 'D3XGC1NCqYT7YWZaIyUBaChwXgYIvA6kfSQZAswsyBv27emZmzMvTKXiOjcK', '2026-03-26 08:37:27', '2026-03-26 10:24:43', 'agent', 0),
(90, 'DUFITUMUKIZA Chadrack', 'dufitumukizachadrack@gmail.com', NULL, '$2y$12$Ou9frIpx.QK3wxLJzCNM0eTyKC3mx9Udw9ayOQvfPU7KK8Y2Fn5V.', NULL, '2026-03-26 09:00:07', '2026-03-26 09:00:07', 'agent', 0),
(92, 'IYAKAREMYE Pascal', 'pascaliyakaremye6@gmail.com', NULL, '$2y$12$nJJBDmDjpRAeqZt/.9kaQuOPLbpiupJOx.5996FoTcMbek33QuuX.', 'zKQcxjM2H5Fs0qahwsKl6e1NtyJ6SXTo3nw9pfvKbQKgYR3Ohs52hF4nhXbI', '2026-03-26 09:10:31', '2026-03-26 11:36:54', 'agent', 0),
(96, 'IRADUKUNDA delphine', 'delphineiradukunda853@gmail.com', NULL, '$2y$12$7sBrYLJ20hwwjMkhwwvitOowDDp0SBtUGUji7lhpMALchKrygcVTi', '5XPGbToglbcdZ72jXo27pCDXEPyiBtWqZQk9Xh2NlviJMyXcE7EhdVyE2O5P', '2026-03-26 11:37:06', '2026-03-26 11:51:32', 'agent', 0),
(97, 'Mutesa charles', 'mutesa958@gmail.com', NULL, '$2y$12$8zaObNbb7Npp.ABFAfwkb.v1MOqEvowq0sG9ABzoRjJRpOk3WldcG', NULL, '2026-03-27 05:41:51', '2026-03-27 05:41:51', 'user', 0),
(100, 'HABIYAREMYE Bertin', 'habiyaremyebertin6@gmail.com', NULL, '$2y$12$HKqcqSkAXo.5SeCsEAekSeu79pc0xsEv//n3GS7zaSSEDQA.wE4BC', NULL, '2026-03-27 09:28:27', '2026-03-27 09:28:27', 'agent', 0),
(101, 'Johnson NTAWIGENERA', 'johnsonntawigenera086@gmail.com', NULL, '$2y$12$1./ybyD0zRbOQyoy.PiGSuA1/dcOJfk4ZkS3ArLUfOzYgDTNJy2am', NULL, '2026-03-28 20:56:11', '2026-03-28 20:56:11', 'user', 0);

-- --------------------------------------------------------

--
-- Table structure for table `villages`
--

CREATE TABLE `villages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cell_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `advertisements_agent_id_foreign` (`agent_id`),
  ADD KEY `advertisements_advertisable_type_advertisable_id_index` (`advertisable_type`,`advertisable_id`);

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `agents_email_unique` (`email`),
  ADD KEY `agents_user_id_foreign` (`user_id`),
  ADD KEY `agents_agent_level_id_foreign` (`agent_level_id`);

--
-- Indexes for table `agent_appointments`
--
ALTER TABLE `agent_appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agent_appointments_agent_id_foreign` (`agent_id`);

--
-- Indexes for table `agent_commissions`
--
ALTER TABLE `agent_commissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agent_commissions_agent_id_foreign` (`agent_id`),
  ADD KEY `agent_commissions_commissionable_type_commissionable_id_index` (`commissionable_type`,`commissionable_id`),
  ADD KEY `agent_commissions_listing_package_id_foreign` (`listing_package_id`),
  ADD KEY `agent_commissions_agent_level_id_foreign` (`agent_level_id`);

--
-- Indexes for table `agent_levels`
--
ALTER TABLE `agent_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agent_reviews`
--
ALTER TABLE `agent_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agent_reviews_agent_id_foreign` (`agent_id`);

--
-- Indexes for table `agent_service`
--
ALTER TABLE `agent_service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agent_service_agent_id_foreign` (`agent_id`),
  ADD KEY `agent_service_service_id_foreign` (`service_id`);

--
-- Indexes for table `agent_stats`
--
ALTER TABLE `agent_stats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `agent_stats_agent_id_unique` (`agent_id`),
  ADD KEY `agent_stats_level_id_foreign` (`level_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `announcements_slug_unique` (`slug`),
  ADD KEY `announcements_created_by_foreign` (`created_by`);

--
-- Indexes for table `architectural_designs`
--
ALTER TABLE `architectural_designs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `architectural_designs_slug_unique` (`slug`),
  ADD KEY `architectural_designs_user_id_foreign` (`user_id`),
  ADD KEY `architectural_designs_category_id_foreign` (`category_id`),
  ADD KEY `architectural_designs_service_id_foreign` (`service_id`),
  ADD KEY `architectural_designs_agent_id_foreign` (`agent_id`),
  ADD KEY `architectural_designs_added_by_foreign` (`added_by`),
  ADD KEY `architectural_designs_listing_package_id_foreign` (`listing_package_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blogs_slug_unique` (`slug`),
  ADD KEY `blogs_user_id_foreign` (`user_id`),
  ADD KEY `blogs_blog_category_id_foreign` (`blog_category_id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_categories_slug_unique` (`slug`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `cells`
--
ALTER TABLE `cells`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cells_sector_id_foreign` (`sector_id`);

--
-- Indexes for table `consultants`
--
ALTER TABLE `consultants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultants_user_id_foreign` (`user_id`);

--
-- Indexes for table `consultant_appointments`
--
ALTER TABLE `consultant_appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultant_appointments_consultant_id_foreign` (`consultant_id`);

--
-- Indexes for table `consultant_commissions`
--
ALTER TABLE `consultant_commissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultant_commissions_consultant_id_foreign` (`consultant_id`),
  ADD KEY `consultant_commissions_client_id_foreign` (`client_id`),
  ADD KEY `consultant_commissions_commission_tier_id_foreign` (`commission_tier_id`);

--
-- Indexes for table `consultant_commission_tiers`
--
ALTER TABLE `consultant_commission_tiers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consultant_reviews`
--
ALTER TABLE `consultant_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultant_reviews_consultant_id_foreign` (`consultant_id`);

--
-- Indexes for table `consultant_service_category`
--
ALTER TABLE `consultant_service_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `consultant_service_unique` (`consultant_id`,`service_category_id`),
  ADD KEY `consultant_service_category_service_category_id_foreign` (`service_category_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_code_unique` (`code`);

--
-- Indexes for table `design_categories`
--
ALTER TABLE `design_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `design_categories_slug_unique` (`slug`);

--
-- Indexes for table `design_orders`
--
ALTER TABLE `design_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `design_orders_user_id_foreign` (`user_id`),
  ADD KEY `design_orders_architectural_design_id_foreign` (`architectural_design_id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `districts_province_id_foreign` (`province_id`);

--
-- Indexes for table `duration_discounts`
--
ALTER TABLE `duration_discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `facilities_slug_unique` (`slug`);

--
-- Indexes for table `facility_house`
--
ALTER TABLE `facility_house`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `facility_house_house_id_facility_id_unique` (`house_id`,`facility_id`),
  ADD KEY `facility_house_facility_id_foreign` (`facility_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `houses`
--
ALTER TABLE `houses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `houses_user_id_foreign` (`user_id`),
  ADD KEY `houses_service_id_foreign` (`service_id`),
  ADD KEY `houses_agent_id_foreign` (`agent_id`),
  ADD KEY `houses_added_by_foreign` (`added_by`),
  ADD KEY `houses_listing_package_id_foreign` (`listing_package_id`);

--
-- Indexes for table `house_images`
--
ALTER TABLE `house_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `house_images_house_id_foreign` (`house_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lands`
--
ALTER TABLE `lands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lands_user_id_foreign` (`user_id`),
  ADD KEY `lands_service_id_foreign` (`service_id`),
  ADD KEY `lands_agent_id_foreign` (`agent_id`),
  ADD KEY `lands_added_by_foreign` (`added_by`),
  ADD KEY `lands_listing_package_id_foreign` (`listing_package_id`);

--
-- Indexes for table `land_images`
--
ALTER TABLE `land_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `land_images_land_id_foreign` (`land_id`);

--
-- Indexes for table `listings`
--
ALTER TABLE `listings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `listings_user_id_foreign` (`user_id`),
  ADD KEY `listings_agent_id_foreign` (`agent_id`),
  ADD KEY `listings_listing_package_id_foreign` (`listing_package_id`);

--
-- Indexes for table `listing_commissions`
--
ALTER TABLE `listing_commissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `listing_commissions_listing_id_foreign` (`listing_id`),
  ADD KEY `listing_commissions_agent_id_foreign` (`agent_id`),
  ADD KEY `listing_commissions_listing_package_id_foreign` (`listing_package_id`);

--
-- Indexes for table `listing_packages`
--
ALTER TABLE `listing_packages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `listing_packages_listing_type_package_tier_unique` (`listing_type`,`package_tier`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_property_plan_order_id_foreign` (`property_plan_order_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `pricing_plans`
--
ALTER TABLE `pricing_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `professionals`
--
ALTER TABLE `professionals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `professionals_email_unique` (`email`),
  ADD KEY `professionals_user_id_foreign` (`user_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `properties_user_id_foreign` (`user_id`);

--
-- Indexes for table `property_media`
--
ALTER TABLE `property_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_media_property_id_foreign` (`property_id`);

--
-- Indexes for table `property_plan_orders`
--
ALTER TABLE `property_plan_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_plan_orders_property_type_property_id_index` (`property_type`,`property_id`),
  ADD KEY `property_plan_orders_user_id_foreign` (`user_id`),
  ADD KEY `property_plan_orders_pricing_plan_id_foreign` (`pricing_plan_id`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_permissions_role_id_foreign` (`role_id`),
  ADD KEY `role_permissions_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `sectors`
--
ALTER TABLE `sectors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sectors_district_id_foreign` (`district_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `services_slug_unique` (`slug`),
  ADD KEY `services_service_category_id_foreign` (`service_category_id`),
  ADD KEY `services_service_subcategory_id_foreign` (`service_subcategory_id`);

--
-- Indexes for table `service_categories`
--
ALTER TABLE `service_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_categories_slug_unique` (`slug`);

--
-- Indexes for table `service_sub_categories`
--
ALTER TABLE `service_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_sub_categories_service_category_id_slug_unique` (`service_category_id`,`slug`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_employee_id_unique` (`employee_id`),
  ADD KEY `staff_user_id_foreign` (`user_id`),
  ADD KEY `staff_department_id_foreign` (`department_id`);

--
-- Indexes for table `tenders`
--
ALTER TABLE `tenders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tenders_reference_no_unique` (`reference_no`),
  ADD KEY `tenders_user_id_foreign` (`user_id`);

--
-- Indexes for table `terra_jobs`
--
ALTER TABLE `terra_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terra_job_applications`
--
ALTER TABLE `terra_job_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `terra_job_applications_job_id_foreign` (`job_id`),
  ADD KEY `terra_job_applications_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `villages`
--
ALTER TABLE `villages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `villages_cell_id_foreign` (`cell_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `agent_appointments`
--
ALTER TABLE `agent_appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agent_commissions`
--
ALTER TABLE `agent_commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `agent_levels`
--
ALTER TABLE `agent_levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `agent_reviews`
--
ALTER TABLE `agent_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agent_service`
--
ALTER TABLE `agent_service`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `agent_stats`
--
ALTER TABLE `agent_stats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `architectural_designs`
--
ALTER TABLE `architectural_designs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cells`
--
ALTER TABLE `cells`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `consultants`
--
ALTER TABLE `consultants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `consultant_appointments`
--
ALTER TABLE `consultant_appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `consultant_commissions`
--
ALTER TABLE `consultant_commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `consultant_commission_tiers`
--
ALTER TABLE `consultant_commission_tiers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `consultant_reviews`
--
ALTER TABLE `consultant_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `consultant_service_category`
--
ALTER TABLE `consultant_service_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `design_categories`
--
ALTER TABLE `design_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `design_orders`
--
ALTER TABLE `design_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `duration_discounts`
--
ALTER TABLE `duration_discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `facility_house`
--
ALTER TABLE `facility_house`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `houses`
--
ALTER TABLE `houses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `house_images`
--
ALTER TABLE `house_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lands`
--
ALTER TABLE `lands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `land_images`
--
ALTER TABLE `land_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `listings`
--
ALTER TABLE `listings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `listing_commissions`
--
ALTER TABLE `listing_commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `listing_packages`
--
ALTER TABLE `listing_packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pricing_plans`
--
ALTER TABLE `pricing_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `professionals`
--
ALTER TABLE `professionals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `property_media`
--
ALTER TABLE `property_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `property_plan_orders`
--
ALTER TABLE `property_plan_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sectors`
--
ALTER TABLE `sectors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `service_categories`
--
ALTER TABLE `service_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `service_sub_categories`
--
ALTER TABLE `service_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tenders`
--
ALTER TABLE `tenders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terra_jobs`
--
ALTER TABLE `terra_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terra_job_applications`
--
ALTER TABLE `terra_job_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `villages`
--
ALTER TABLE `villages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `advertisements`
--
ALTER TABLE `advertisements`
  ADD CONSTRAINT `advertisements_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `agents`
--
ALTER TABLE `agents`
  ADD CONSTRAINT `agents_agent_level_id_foreign` FOREIGN KEY (`agent_level_id`) REFERENCES `agent_levels` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `agents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `agent_appointments`
--
ALTER TABLE `agent_appointments`
  ADD CONSTRAINT `agent_appointments_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `agent_commissions`
--
ALTER TABLE `agent_commissions`
  ADD CONSTRAINT `agent_commissions_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `agent_commissions_agent_level_id_foreign` FOREIGN KEY (`agent_level_id`) REFERENCES `agent_levels` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `agent_commissions_listing_package_id_foreign` FOREIGN KEY (`listing_package_id`) REFERENCES `listing_packages` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `agent_reviews`
--
ALTER TABLE `agent_reviews`
  ADD CONSTRAINT `agent_reviews_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `agent_service`
--
ALTER TABLE `agent_service`
  ADD CONSTRAINT `agent_service_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `agent_service_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `agent_stats`
--
ALTER TABLE `agent_stats`
  ADD CONSTRAINT `agent_stats_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `agent_stats_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `agent_levels` (`id`);

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `architectural_designs`
--
ALTER TABLE `architectural_designs`
  ADD CONSTRAINT `architectural_designs_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `architectural_designs_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `architectural_designs_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `design_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `architectural_designs_listing_package_id_foreign` FOREIGN KEY (`listing_package_id`) REFERENCES `listing_packages` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `architectural_designs_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `architectural_designs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_blog_category_id_foreign` FOREIGN KEY (`blog_category_id`) REFERENCES `blog_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blogs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cells`
--
ALTER TABLE `cells`
  ADD CONSTRAINT `cells_sector_id_foreign` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `consultants`
--
ALTER TABLE `consultants`
  ADD CONSTRAINT `consultants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `consultant_appointments`
--
ALTER TABLE `consultant_appointments`
  ADD CONSTRAINT `consultant_appointments_consultant_id_foreign` FOREIGN KEY (`consultant_id`) REFERENCES `consultants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `consultant_commissions`
--
ALTER TABLE `consultant_commissions`
  ADD CONSTRAINT `consultant_commissions_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `consultant_commissions_commission_tier_id_foreign` FOREIGN KEY (`commission_tier_id`) REFERENCES `consultant_commission_tiers` (`id`),
  ADD CONSTRAINT `consultant_commissions_consultant_id_foreign` FOREIGN KEY (`consultant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `consultant_reviews`
--
ALTER TABLE `consultant_reviews`
  ADD CONSTRAINT `consultant_reviews_consultant_id_foreign` FOREIGN KEY (`consultant_id`) REFERENCES `consultants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `consultant_service_category`
--
ALTER TABLE `consultant_service_category`
  ADD CONSTRAINT `consultant_service_category_consultant_id_foreign` FOREIGN KEY (`consultant_id`) REFERENCES `consultants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `consultant_service_category_service_category_id_foreign` FOREIGN KEY (`service_category_id`) REFERENCES `service_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `design_orders`
--
ALTER TABLE `design_orders`
  ADD CONSTRAINT `design_orders_architectural_design_id_foreign` FOREIGN KEY (`architectural_design_id`) REFERENCES `architectural_designs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `design_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_province_id_foreign` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `facility_house`
--
ALTER TABLE `facility_house`
  ADD CONSTRAINT `facility_house_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `facility_house_house_id_foreign` FOREIGN KEY (`house_id`) REFERENCES `houses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `houses`
--
ALTER TABLE `houses`
  ADD CONSTRAINT `houses_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `houses_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `houses_listing_package_id_foreign` FOREIGN KEY (`listing_package_id`) REFERENCES `listing_packages` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `houses_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `houses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `house_images`
--
ALTER TABLE `house_images`
  ADD CONSTRAINT `house_images_house_id_foreign` FOREIGN KEY (`house_id`) REFERENCES `houses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lands`
--
ALTER TABLE `lands`
  ADD CONSTRAINT `lands_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `lands_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `lands_listing_package_id_foreign` FOREIGN KEY (`listing_package_id`) REFERENCES `listing_packages` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `lands_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `lands_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `land_images`
--
ALTER TABLE `land_images`
  ADD CONSTRAINT `land_images_land_id_foreign` FOREIGN KEY (`land_id`) REFERENCES `lands` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `listings`
--
ALTER TABLE `listings`
  ADD CONSTRAINT `listings_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `listings_listing_package_id_foreign` FOREIGN KEY (`listing_package_id`) REFERENCES `listing_packages` (`id`),
  ADD CONSTRAINT `listings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `listing_commissions`
--
ALTER TABLE `listing_commissions`
  ADD CONSTRAINT `listing_commissions_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `listing_commissions_listing_id_foreign` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `listing_commissions_listing_package_id_foreign` FOREIGN KEY (`listing_package_id`) REFERENCES `listing_packages` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_property_plan_order_id_foreign` FOREIGN KEY (`property_plan_order_id`) REFERENCES `property_plan_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `professionals`
--
ALTER TABLE `professionals`
  ADD CONSTRAINT `professionals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `property_media`
--
ALTER TABLE `property_media`
  ADD CONSTRAINT `property_media_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `property_plan_orders`
--
ALTER TABLE `property_plan_orders`
  ADD CONSTRAINT `property_plan_orders_pricing_plan_id_foreign` FOREIGN KEY (`pricing_plan_id`) REFERENCES `pricing_plans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `property_plan_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sectors`
--
ALTER TABLE `sectors`
  ADD CONSTRAINT `sectors_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_service_category_id_foreign` FOREIGN KEY (`service_category_id`) REFERENCES `service_categories` (`id`),
  ADD CONSTRAINT `services_service_subcategory_id_foreign` FOREIGN KEY (`service_subcategory_id`) REFERENCES `service_sub_categories` (`id`);

--
-- Constraints for table `service_sub_categories`
--
ALTER TABLE `service_sub_categories`
  ADD CONSTRAINT `service_sub_categories_service_category_id_foreign` FOREIGN KEY (`service_category_id`) REFERENCES `service_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `staff_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tenders`
--
ALTER TABLE `tenders`
  ADD CONSTRAINT `tenders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `terra_job_applications`
--
ALTER TABLE `terra_job_applications`
  ADD CONSTRAINT `terra_job_applications_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `terra_jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `terra_job_applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `villages`
--
ALTER TABLE `villages`
  ADD CONSTRAINT `villages_cell_id_foreign` FOREIGN KEY (`cell_id`) REFERENCES `cells` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
