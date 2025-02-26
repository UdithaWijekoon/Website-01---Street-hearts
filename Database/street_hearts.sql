-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2024 at 07:57 PM
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
-- Database: `street_hearts`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `AdminID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Role` varchar(50) DEFAULT 'Administrator',
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`AdminID`, `Username`, `Password`, `Email`, `Role`, `CreatedAt`, `UpdatedAt`) VALUES
(1, 'admin_1', '$2y$10$d4GMMhqcjEqTlzmCnJ4yUOk/hUuTRxESYmJn9wCB.E7qjucuyjNRC', 'udithawijekoon.900@gmail.com', 'Administrator', '2024-09-13 04:55:04', '2024-10-08 13:59:39'),
(6, 'admin_2', '$2y$10$6CI.h6Isx3vcrhJBC9hB7OioA7NzTGOlSTRk6jd/c3yFy8PfqZizK', 'admin_2@gmail.com', 'Administrator', '2024-09-13 17:33:13', '2024-09-21 14:24:43'),
(12, 'admin_3', '$2y$10$A2TAhVMllMtVRyCxGsoeVOZY7C8doZzCtQDtAAlTG/LWbA9dCbF4O', 'kaveeshabandara846@gmail.com', 'Administrator', '2024-10-04 13:45:09', '2024-10-08 17:02:40');

-- --------------------------------------------------------

--
-- Table structure for table `admin_messages`
--

CREATE TABLE `admin_messages` (
  `MessageID` int(11) NOT NULL,
  `SenderAdminID` int(11) NOT NULL,
  `ReceiverUserID` int(11) DEFAULT NULL,
  `ReceiverShelterID` int(11) DEFAULT NULL,
  `Subject` varchar(255) NOT NULL,
  `MessageContent` text NOT NULL,
  `SentAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_messages`
--

INSERT INTO `admin_messages` (`MessageID`, `SenderAdminID`, `ReceiverUserID`, `ReceiverShelterID`, `Subject`, `MessageContent`, `SentAt`) VALUES
(5, 1, NULL, 3, 'test', 'test', '2024-09-15 09:12:48'),
(17, 1, 1, NULL, 'Test Case 20', 'Testing Message', '2024-10-08 06:56:55'),
(18, 1, NULL, 3, 'Update on Pet Reports', 'Dear Shelter Team,\r\nWe have received multiple reports of street pets in your area. Please review the reports and take the necessary actions to rescue these animals. We rely on your support to ensure the safety and care of these pets. Let us know if you need any further assistance from our side.\r\nBest regards,\r\nAdmin Team', '2024-10-08 17:33:40'),
(19, 1, NULL, 4, 'Upcoming Adoption Event Preparation', 'Hello,\r\nAs part of our upcoming adoption event, we are asking all shelters to prepare their pets\' profiles and ensure they are up-to-date in the system. Please review your pet profiles by the end of this week, and let us know if you need help with anything.\r\nThank you for your cooperation,\r\nAdmin Team', '2024-10-08 17:33:53'),
(20, 1, 1, NULL, 'Your Pet Report Update', 'Dear User_1,\r\nWe have received your report about the street pet in your area. The shelter has been notified, and they will take appropriate action as soon as possible. Thank you for helping us care for these animals.\r\nBest regards,\r\nAdmin Team', '2024-10-08 17:34:18'),
(21, 1, 5, NULL, 'Adoption Application Received', 'Hello User_2,\r\nWe have successfully received your adoption application. Our team is reviewing your details, and you can expect to hear from us within the next few days. Thank you for your interest in providing a loving home to one of our pets.\r\nWarm regards,\r\nAdmin Team', '2024-10-08 17:34:32');

-- --------------------------------------------------------

--
-- Table structure for table `adoption_applications`
--

CREATE TABLE `adoption_applications` (
  `ApplicationID` int(11) NOT NULL,
  `PetID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ReasonForAdoption` text DEFAULT NULL,
  `PreviousPetOwnershipExperience` tinyint(1) DEFAULT NULL,
  `HomeEnvironmentDescription` text DEFAULT NULL,
  `ContactInformation` varchar(255) DEFAULT NULL,
  `AgreeToTerms` tinyint(1) DEFAULT NULL,
  `ApplicationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `Status` enum('Pending','Approved','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adoption_applications`
--

INSERT INTO `adoption_applications` (`ApplicationID`, `PetID`, `UserID`, `ReasonForAdoption`, `PreviousPetOwnershipExperience`, `HomeEnvironmentDescription`, `ContactInformation`, `AgreeToTerms`, `ApplicationDate`, `Status`) VALUES
(31, 32, 1, 'I needed a pet since a long time', 1, 'Good Environment', '0712345678', 1, '2024-10-08 16:58:28', 'Approved'),
(32, 35, 1, 'I needed a cat', 0, 'Good', '0752345678', 1, '2024-10-08 16:59:38', 'Approved'),
(33, 36, 1, 'I love Cats', 1, 'Nice', '0746845678', 1, '2024-10-08 17:00:58', 'Approved'),
(34, 27, 1, 'I needed a dog for safety', 0, 'Good', '0758765678', 1, '2024-10-08 17:01:55', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `DistrictID` int(11) NOT NULL,
  `DistrictName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`DistrictID`, `DistrictName`) VALUES
(1, 'Ampara'),
(2, 'Anuradhapura'),
(3, 'Badulla'),
(4, 'Batticaloa'),
(5, 'Colombo'),
(6, 'Galle'),
(7, 'Gampaha'),
(8, 'Hambantota'),
(9, 'Jaffna'),
(10, 'Kalutara'),
(11, 'Kandy'),
(12, 'Kegalle'),
(13, 'Kilinochchi'),
(14, 'Kurunegala'),
(15, 'Mannar'),
(16, 'Matale'),
(17, 'Matara'),
(18, 'Monaragala'),
(19, 'Mullaitivu'),
(20, 'Nuwara Eliya'),
(21, 'Polonnaruwa'),
(22, 'Puttalam'),
(23, 'Ratnapura'),
(24, 'Trincomalee'),
(25, 'Vavuniya');

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `DonationID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `DonatorName` varchar(255) NOT NULL,
  `DonationAmount` decimal(10,2) NOT NULL,
  `PaymentReceipt` varchar(255) NOT NULL,
  `DonationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`DonationID`, `UserID`, `DonatorName`, `DonationAmount`, `PaymentReceipt`, `DonationDate`) VALUES
(13, 1, 'Uditha Wijekoon', 500.00, '../uploads/donations/d1.jpeg', '2024-10-08 17:29:11'),
(14, 1, 'Yasiru Liyanage', 450.00, '../uploads/donations/d2.jpeg', '2024-10-08 17:30:04');

-- --------------------------------------------------------

--
-- Table structure for table `educational_content`
--

CREATE TABLE `educational_content` (
  `ContentID` int(11) NOT NULL,
  `Category` enum('Dogs','Cats') NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Content` text NOT NULL,
  `ImageURL` varchar(255) DEFAULT NULL,
  `DatePosted` timestamp NOT NULL DEFAULT current_timestamp(),
  `AdminID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `educational_content`
--

INSERT INTO `educational_content` (`ContentID`, `Category`, `Title`, `Content`, `ImageURL`, `DatePosted`, `AdminID`) VALUES
(3, 'Dogs', '10 Things to Know When You Adopt a Puppy', '10 Things to Know When You Adopt a Puppy!\r\n\r\nAdopting a puppy is a life-changing decision. Your family will have a new member and you’ll gain a new best friend. It’s the best decision you can make, but once you bring your paw-some friend home, there are a few important things to keep in mind to ensure their health and well-being:\r\n\r\n    De-Worming Your Pup\r\n    Worms are common in puppies but can be deadly if left untreated. Puppies under 3 months need de-worming every 2 weeks. After 3 months, de-worm every month, and after 6 months, every 3 months. Consult your vet for the right treatment based on your puppy’s weight.\r\n\r\n    Vitamins\r\n    Growing puppies need vitamins for optimal health. Consult your vet to determine which vitamins are best for your pup’s needs.\r\n\r\n    Keep an Eye Out for Ticks\r\n    Ticks can hide in your puppy’s fur and carry diseases. Regularly check your pup’s paws and ears for ticks and consult your vet about tick prevention.\r\n\r\n    Vaccinations\r\n    Ensure your puppy is vaccinated on time. Keep a vaccination book and administer crucial vaccines such as Rabies, PARVO, and DHL.\r\n\r\n    Dental Care\r\n    Oral hygiene is essential. Train your puppy to get used to tooth brushing, but use toothpaste specifically for dogs.\r\n\r\n    Skin Issues\r\n    Puppies can develop skin issues like rashes or excessive scratching. Use kohomba oil as a first treatment. If issues persist, consult your vet.\r\n\r\n    Brush Your Pup’s Coat Regularly\r\n    Regular brushing helps maintain a shiny coat and prevents ticks and fleas.\r\n\r\n    Bathing\r\n    Bathe your puppy only after they’re 3.5 months old. Before that, use a sponge bath with warm water. Avoid bathing immediately after vaccinations; wait at least 5 days.\r\n\r\n    Monitor Behavior\r\n    If your puppy isn’t eating, seems lethargic, or is behaving unusually, visit your vet promptly.\r\n\r\n    Be Patient\r\n    Puppies are energetic and may have accidents. Give them time to adapt, learn commands, and always be patient.\r\n\r\nMost importantly, always choose to adopt!', '../uploads/content/1726321245_dog_care.jpg', '2024-09-14 13:40:45', 1),
(4, 'Cats', 'How to Care for Kittens', 'Tips for Keeping Your Cat Safe\r\n\r\n    Secure Your Home\r\n    Ensure windows, balconies, and doors are secure to prevent your cat from escaping.\r\n\r\n    Microchip Your Cat\r\n    Microchipping provides a permanent form of identification if your cat goes missing.\r\n\r\n    Use a Collar with ID Tags\r\n    Even if your cat is microchipped, a collar with an ID tag can help in identifying your pet quickly.\r\n\r\n    Provide Enrichment\r\n    Keep your cat stimulated with toys, climbing structures, and interactive play to reduce the desire to wander.\r\n\r\n    Train Your Cat\r\n    Train your cat to be comfortable with handling and various environments. This can help in emergencies.\r\n\r\n    Regular Vet Checkups\r\n    Regular checkups can help catch health issues early and keep your cat in good shape.\r\n\r\n    Keep Dangerous Items Out of Reach\r\n    Ensure toxic plants, chemicals, and small objects are inaccessible to prevent poisoning or choking.\r\n\r\n    Use Safe Cat-Friendly Products\r\n    Use cat-safe products for grooming and cleaning to avoid any adverse reactions.\r\n\r\n    Spay/Neuter Your Cat\r\n    Spaying or neutering reduces the likelihood of roaming and unwanted litters.\r\n\r\n    Create a Safe Outdoor Space\r\n    If you want your cat to experience the outdoors, consider a catio or enclosed outdoor area to keep them safe from traffic and predators.', '../uploads/content/1726321301_cat_care.jpg', '2024-09-14 13:41:41', 1);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `EventID` int(11) NOT NULL,
  `EventName` varchar(255) NOT NULL,
  `EventDescription` text NOT NULL,
  `EventDate` date NOT NULL,
  `EventTime` time NOT NULL,
  `Location` varchar(255) NOT NULL,
  `CreatedByAdmin` int(11) NOT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `CreatedDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`EventID`, `EventName`, `EventDescription`, `EventDate`, `EventTime`, `Location`, `CreatedByAdmin`, `Image`, `CreatedDate`) VALUES
(11, 'Pet Adoption Drive', 'Join us for a fun-filled day of meeting adorable pets looking for their forever homes. Whether you’re looking to adopt or just want to spend time with the animals, this event is perfect for pet lovers of all ages. Shelter volunteers will be on hand to answer any questions and help match you with the perfect pet.', '2024-12-12', '08:00:00', 'Kandy City Center, Kandy', 1, '../uploads/events/cat_care.jpg', '2024-10-08 17:15:26'),
(12, 'Vaccination and Microchipping Clinic', 'Ensure your pet’s health and safety by attending our vaccination and microchipping clinic. Get your pets vaccinated and microchipped at a discounted rate by professional vets. This event aims to help keep pets safe and reunite lost pets with their families more easily.', '2024-09-12', '09:00:00', 'Badulla Municipal Grounds, Badulla', 1, '../uploads/events/dog_care.jpg', '2024-10-08 17:16:02'),
(13, 'Street Pet Awareness Workshop', 'Learn how to help street pets in your community! This workshop covers how to safely report, rescue, and care for street animals in need. You\'ll also hear success stories from previous rescues and adoptions. Open to anyone interested in learning more about supporting street pets.\r\n', '2025-05-01', '08:00:00', 'Kandy', 1, '../uploads/events/Dog7.jpg', '2024-10-08 17:16:29');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `FeedbackID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Rating` int(1) DEFAULT NULL CHECK (`Rating` >= 1 and `Rating` <= 5),
  `Comments` text DEFAULT NULL,
  `FeedbackDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`FeedbackID`, `UserID`, `Rating`, `Comments`, `FeedbackDate`) VALUES
(7, 1, 4, 'Nice adoption platform', '2024-10-08 05:08:22');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `MessageID` int(11) NOT NULL,
  `SenderUserID` int(11) DEFAULT NULL,
  `ReceiverAdminID` int(11) DEFAULT NULL,
  `ReceiverShelterID` int(11) DEFAULT NULL,
  `Subject` varchar(255) NOT NULL,
  `MessageContent` text NOT NULL,
  `SentAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`MessageID`, `SenderUserID`, `ReceiverAdminID`, `ReceiverShelterID`, `Subject`, `MessageContent`, `SentAt`) VALUES
(14, 1, NULL, 3, 'Test 1', 'testing', '2024-10-06 13:41:45'),
(21, 1, 1, NULL, 'test 3', 'assad', '2024-10-08 14:03:51'),
(36, 1, 1, NULL, 'Query About Adoption Process', 'Hello Admin,\r\nI’m interested in adopting a dog, but I have some questions about the process. Could you please explain how long it usually takes to complete the adoption procedure and what documentation I would need to provide? Thank you for your help.', '2024-10-08 17:23:10'),
(37, 1, 1, NULL, 'Issue with Website Login', 'Hi Admin,\r\nI’m having trouble logging into my account on the website. I’ve tried resetting my password, but I still can’t access my profile. Can you assist me in resolving this issue? Looking forward to your response', '2024-10-08 17:23:22'),
(38, 1, 1, NULL, 'Suggestion for Improving the User Dashboard', 'Dear Admin,\r\nI’ve been using the user dashboard to manage my adoption requests, and I thought of a suggestion. It would be great if there was a feature to track the status of my applications more clearly. Could this be considered in future updates? Thank you for your time.', '2024-10-08 17:23:33'),
(39, 1, NULL, 3, 'Inquiry About a Specific Pet', 'I recently saw a dog listed on your site, and I’m very interested in adopting him. Could you provide more details about his temperament and any special care requirements? His name is ‘Buddy,’ and I’m hoping to meet him soon. Thank you.', '2024-10-08 17:23:58'),
(40, 1, NULL, 3, 'Volunteering at Your Shelter', 'I’m really passionate about helping animals and would love to volunteer at your shelter. Are there any upcoming opportunities to assist with caring for the animals or helping out during events? Please let me know how I can get involved.', '2024-10-08 17:24:12'),
(41, 1, NULL, 4, 'Donation of Pet Supplies', 'Dear Shelter Team,\r\nI have some pet supplies, such as food, toys, and bedding, that I would like to donate to your shelter. Could you let me know the best way to drop them off or if there’s anything specific your animals need at the moment? Thank you for the work you do.', '2024-10-08 17:24:26');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(100) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `expires_at`) VALUES
(2, 'zdfd@g.com', '1ffd2658198d098498d0cdba90722a093046e3ee86d7c4f39f18c0d25bb6cf39bda4b0770f9f15fb3b94002ea37bfe298967', '2024-09-21 05:36:25'),
(3, 'udithawijekoon.900@gmail.com', '11dc3f8a1f1d0cf137749e059cba82dab017d1a49b3ce975ee3bdc36cba18d25865ce202da8153a559c1d8920fa1c824a2a8', '2024-09-21 05:38:35'),
(4, 'udithawijekoon.900@gmail.com', 'f3eeee44c76b58ac12ea682c7871e8821beb0a63f07a41a5c83ecb26cb17b7ff1874ce4b5ef75ebdae6f9b804f8115226edc', '2024-09-21 05:56:02'),
(5, 'udithawijekoon.900@gmail.com', '4996eeb7b0fed74d0adf94be81c320b0ae8488a5b841926cb55839053db3ee3b17740d28206745fe11f99aefff26ccac2296', '2024-09-21 06:06:45'),
(6, 'udithawijekoon.900@gmail.com', '71582632501abf2cfdaa10f43c1f1bed6f27e4381538019cbc7c90cc33fd359bffd61fbaac437078d5f6161d2053e91f3efe', '2024-09-21 06:38:35'),
(7, 'udithawijekoon.900@gmail.com', 'd3674a1a22af2aa9bd56d8d312db791de0b53bddf7c8a538754761589bc284f96589848703228f421058c75af81e1ef27718', '2024-09-21 06:42:01'),
(8, 'udithawijekoon.900@gmail.com', '96fe52e7c73f70e95e4267bce7805fba4c39e721eac1d33520e8bcd4a77d1b647b43b0e4731519888cb5ca0c908df1332b89', '2024-09-21 06:48:15'),
(9, 'udithawijekoon.900@gmail.com', 'af239df84d2668e45d289f7b4e602a1265d4fda364519328206e458e9892e25b9a112daf5b3b0cc0d720bc00687cc0c447e2', '2024-09-21 06:52:06'),
(10, 'udithawijekoon.900@gmail.com', '6f4adca497f3722bddbf4ea886e64bab823039e10fbf1b9e0dc5c638fe9a19b087a55b3dae066494c89828575c971963809e', '2024-09-21 06:53:36'),
(14, 'udithawijekoon.900@gmail.com', '2499f3c5ac790dc75fb92e2438e64652bdc87834a6a592e8275d37110819efd0e6495c3942485868c9a6689501cbe94fd3d1', '2024-09-21 07:05:08'),
(20, 'udithawijekoon.900@gmail.com', '2cac8a513f28800d97c605719d559cfa75ef275d5e46c0c36e9e201b17ae6a4d5c948bd37502473e0b4dc36a88d93900797f', '2024-09-21 07:14:48'),
(21, 'udithawijekoon.900@gmail.com', '75ff012bf4266bd37025ae19d501abf6029d7360168696685544c2c9edc876dfc1085a9b774a9599e3da5727350015274f83', '2024-09-21 07:28:12'),
(25, 'udithawijekoon.900@gmail.com', 'cd27b943c62b4f1701b5b32c2dec689082b961897e36ef1be0870939bf48afd80f364b91955d0e80294d307c6d1041989bcc', '2024-09-21 10:50:36'),
(26, 'udithawijekoon.900@gmail.com', '29ad812ef159f4e7b188989e30ba1dd2f4b5b8a451e621898db4d2381f8990643c42fac969894977290ac0509190b09f2932', '2024-09-21 11:09:31'),
(27, 'udithaerandake.800@gmail.com', '88a34e556fdfe78a5be653ee3b0171b1d584d218df213e309870cc93bec6abdcf1e45c7e787e702c1d6a3f5c51843c1fc3e1', '2024-09-21 11:09:48'),
(28, 'udithawijekoon.900@gmail.com', 'dc393824a827f6cafa573ef3b3ceb8cc14fa8467db92bca7df135646177eeb1284e496bb6d053546004b85234df9ae87b5a7', '2024-09-21 11:11:37'),
(29, 'udithaerandake.800@gmail.com', 'd35a3c9d4fecccaaf706b8b7ed2ccaa4a2f938e0e1db6f0eabaa4682a9d89186b90807026cbc49a38f1d58e2c8389860fa9d', '2024-09-21 11:12:07'),
(37, 'udithaerandake.800@gmail.com', '2d89483a5a44c028712ee46f7547c9a3071b6dd003d22035b3682339ed6b0b6ce31d85555f8539b587060c951f12717410c1', '2024-09-21 11:51:51'),
(38, 'kaveeshabandara846@gmail.com', 'a64815e5183d87e8d573061a4051c65e3f8cadf27ccb484f0a13c9683f490ea4f4c98fe1bd551276ad0546c572ecf362750e', '2024-10-04 16:45:46'),
(39, 'kaveeshabandara846@gmail.com', 'ced9b1173b05bd31f77664102158ab10952ab10bfdf4ff885a3a1c388f41b5eb852fcce3754f2b2efa7a1591282c39aff28c', '2024-10-04 16:48:48');

-- --------------------------------------------------------

--
-- Table structure for table `pending_pets`
--

CREATE TABLE `pending_pets` (
  `PendingPetID` int(11) NOT NULL,
  `PetName` varchar(100) NOT NULL,
  `Breed` varchar(100) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `Gender` enum('Male','Female','Unknown') DEFAULT NULL,
  `Size` varchar(50) DEFAULT NULL,
  `Color` varchar(50) DEFAULT NULL,
  `HealthStatus` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Location` varchar(255) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `ProfilePicture` varchar(255) DEFAULT NULL,
  `ShelterID` int(11) DEFAULT NULL,
  `DateAdded` datetime DEFAULT current_timestamp(),
  `PetType` enum('Cat','Dog','Other') NOT NULL DEFAULT 'Dog'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pending_pets`
--

INSERT INTO `pending_pets` (`PendingPetID`, `PetName`, `Breed`, `Age`, `Gender`, `Size`, `Color`, `HealthStatus`, `Description`, `Location`, `Status`, `ProfilePicture`, `ShelterID`, `DateAdded`, `PetType`) VALUES
(41, 'Diva', 'Rottweiler', 4, 'Male', 'Large', 'Black', 'Vaccinated, Healthy', 'Protective and loyal, great for an experienced owner.', 'Badulla', 'Available', 'Dog 8.jpg', 4, '2024-10-08 22:26:54', 'Dog');

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

CREATE TABLE `pets` (
  `PetID` int(11) NOT NULL,
  `PetName` varchar(100) NOT NULL,
  `Species` varchar(50) DEFAULT NULL,
  `Breed` varchar(50) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `Gender` enum('Male','Female') DEFAULT NULL,
  `Size` enum('Small','Medium','Large') DEFAULT NULL,
  `Color` varchar(50) DEFAULT NULL,
  `HealthStatus` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `ProfilePicture` varchar(255) DEFAULT NULL,
  `Location` varchar(255) DEFAULT NULL,
  `Status` enum('Available','Adopted') DEFAULT 'Available',
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `PetType` enum('Cat','Dog','Other') NOT NULL DEFAULT 'Dog',
  `ShelterID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`PetID`, `PetName`, `Species`, `Breed`, `Age`, `Gender`, `Size`, `Color`, `HealthStatus`, `Description`, `ProfilePicture`, `Location`, `Status`, `CreatedAt`, `PetType`, `ShelterID`) VALUES
(26, 'Bella', NULL, 'Golden Retriever', 3, 'Female', 'Medium', 'Golden', 'Vaccinated, Healthy', 'Friendly and playful, loves attention and long walks.', 'Dog 1.webp', 'Kandy', 'Available', '2024-10-08 16:34:34', 'Dog', 3),
(27, 'Max', NULL, 'German Shepherd', 5, 'Male', 'Small', 'Black and Tan', 'Healthy', 'Loyal and protective, great for an active family.', 'Dog2.jpg', 'Kandy', 'Available', '2024-10-08 16:37:22', 'Dog', 3),
(28, 'Charlie', NULL, 'Beagle', 4, 'Male', 'Small', 'Tricolor', 'Vaccinated, Healthy', 'Energetic and curious, loves to explore.', 'Dog3.jpg', 'Kandy', 'Available', '2024-10-08 16:45:36', 'Dog', 3),
(29, 'Daisy', NULL, 'Labrador Retriever', 1, 'Female', 'Small', 'Black and White', 'Healthy', ' Playful and friendly, perfect for a family with kids.', 'Dog4.jpg', 'Kandy', 'Available', '2024-10-08 16:45:37', 'Dog', 3),
(30, 'Sophie', NULL, 'French Bulldog', 2, 'Female', 'Large', 'Fawn', 'Vaccinated, Healthy', 'Sweet and affectionate, great for small spaces.', 'Dog6.jpg', 'Kandy', 'Available', '2024-10-08 16:45:37', 'Dog', 3),
(31, 'Simba', NULL, 'Bengal', 1, 'Male', 'Small', 'Brown', 'Healthy', 'Energetic and loves climbing, great for an active home.', 'Cat1.jpg', 'Badulla', 'Available', '2024-10-08 16:49:35', 'Cat', 4),
(32, 'Buddy', NULL, 'Border Collie', 2, 'Male', 'Medium', 'Brown', 'Healthy', 'Highly intelligent, needs lots of exercise and stimulation.', 'Dog7.jpg', 'Badulla', 'Adopted', '2024-10-08 16:49:40', 'Dog', 4),
(33, 'Koli', NULL, 'Ragdoll', 5, 'Male', 'Small', 'Brown', 'Vaccinated', 'perfect for a calm household.', 'Cat4.jpeg', 'Badulla', 'Available', '2024-10-08 16:49:42', 'Cat', 4),
(34, 'Ruby', NULL, 'Sphynx', 2, 'Female', 'Medium', 'Gray', 'Healthy', 'Energetic and friendly, loves warm spots and attention.', 'Cat3.webp', 'Badulla', 'Available', '2024-10-08 16:52:59', 'Cat', 4),
(35, 'Misty', NULL, 'Domestic Shorthair', 3, 'Male', 'Small', 'Brown', 'Vaccinated, Healthy', 'Playful and curious, loves chasing toys.', 'Cat2.jpg', '', 'Adopted', '2024-10-08 16:53:00', 'Cat', 4),
(36, 'Ginger', NULL, 'Abyssinian', 3, 'Female', 'Large', 'Gray', 'Vaccinated, Healthy', 'Active and curious, loves to explore new environments.', 'Cat5.jpg', 'Badulla', 'Adopted', '2024-10-08 16:54:25', 'Cat', 4);

-- --------------------------------------------------------

--
-- Table structure for table `pet_care_locations`
--

CREATE TABLE `pet_care_locations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` enum('vet','clinic') NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet_care_locations`
--

INSERT INTO `pet_care_locations` (`id`, `name`, `district`, `address`, `latitude`, `longitude`, `created_at`, `type`, `description`) VALUES
(28, 'Paws & Whiskers Pet Clinic', 'Colombo', '123 Pet Care Lane, Colombo 05, Sri Lanka', 6.93387931, 79.85823239, '2024-10-08 17:37:59', 'clinic', 'Paws & Whiskers is a full-service pet clinic specializing in wellness exams, vaccinations, and general pet health care. The clinic also offers grooming and nutrition advice for both cats and dogs.'),
(29, 'Kandy Animal Clinic', 'Kandy', '56 Mahaweli Avenue, Kandy, Sri Lanka', 7.27783513, 80.62236689, '2024-10-08 17:38:37', 'clinic', 'Kandy Animal Clinic provides comprehensive care for small animals, including preventive health care, dental services, and minor surgeries. It is well-known for its excellent customer service and compassionate staff.'),
(30, 'Four Paws Pet Clinic', 'Galle', '78 Lighthouse Street, Galle, Sri Lanka', 6.02839719, 80.23826797, '2024-10-08 17:39:10', 'clinic', 'Four Paws Pet Clinic is a family-run clinic that offers medical, surgical, and emergency services for pets. They focus on preventive care to keep pets healthy and provide personalized care to each patient.'),
(31, 'Colombo Veterinary Hospital', 'Colombo', '98 Animal Health Road, Colombo 07, Sri Lanka', 6.99440355, 79.91982055, '2024-10-08 17:39:39', 'vet', 'A leading veterinary hospital in Colombo, offering specialized treatments, diagnostic imaging, and advanced surgical procedures for pets. They provide both inpatient and outpatient services.'),
(32, 'Badulla Veterinary Center', 'Badulla', '22 Main Street, Badulla, Sri Lanka', 6.94296759, 81.11125311, '2024-10-08 17:40:12', 'vet', 'Badulla Veterinary Center serves the community with both routine and emergency veterinary care. They have a state-of-the-art facility for pet surgeries, diagnostics, and vaccinations.'),
(33, 'Kurunegala Veterinary Care', 'Kurunegala', '45 Lion’s Lane, Kurunegala, Sri Lanka', 7.72750330, 80.24375844, '2024-10-08 17:40:49', 'vet', 'Kurunegala Veterinary Care specializes in surgical care, pet rehabilitation, and preventive medicine. They are known for their friendly and experienced veterinary staff.');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `report_id` int(11) NOT NULL,
  `pet_description` text NOT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `location_description` varchar(255) DEFAULT NULL,
  `additional_notes` text DEFAULT NULL,
  `report_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `live_location_link` varchar(255) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `approval_status` enum('pending','approved','rejected') DEFAULT 'pending',
  `shelter_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`report_id`, `pet_description`, `photo_url`, `location_description`, `additional_notes`, `report_date`, `live_location_link`, `district`, `approval_status`, `shelter_id`) VALUES
(30, 'Animal Type: Dog\r\nColor: Brown with white spots\r\nSize: Medium\r\nHealth Status: Appears malnourished with minor injuries', '../uploads/reported_pets/R1.jpg', 'Near the Kandy Lake, in a small alley behind a restaurant.', 'The dog was seen limping and looking for food in the trash. Locals have noticed it wandering for a few days.\r\n', '2024-10-08 17:07:46', 'https://maps.app.goo.gl/g858gtRE5Aj9wMGV9', 'Kandy', 'approved', 4),
(31, 'Animal Type: Cat\r\nColor: Black with a white chest\r\nSize: Small\r\nHealth Status: Seems healthy but scared', '../uploads/reported_pets/R5.jpg', 'Found near the Temple of the Sacred Tooth Relic entrance in Kandy. Hiding under the steps.', '', '2024-10-08 17:08:45', 'https://maps.app.goo.gl/7MDkziCn7EyjcjV87', 'Kandy', 'approved', 3),
(32, 'Animal Type: Dog\r\nColor: Golden\r\nSize: Large\r\nHealth Status: Strong and healthy, no visible injuries', '../uploads/reported_pets/R2.jpg', 'Spotted in a busy market area near the Kandy Railway Station.', 'The dog seems friendly and approaches passersby. Looks well-fed but possibly a stray.', '2024-10-08 17:09:31', 'https://maps.app.goo.gl/Fs18GiX9HHMBB86k7', 'Kandy', 'pending', NULL),
(33, 'Animal Type: Dog\r\nColor: Black with a white belly\r\nSize: Small\r\nHealth Status: Looks to have skin issues, possibly mange', '../uploads/reported_pets/R4.jpg', 'Seen near the Badulla bus station, wandering near the parked buses.', 'The dog seems to be scratching a lot and its fur is patchy. It stays near the food vendors.\r\n', '2024-10-08 17:10:31', 'https://maps.app.goo.gl/jvD2giKZdRDea4dMA', 'Badulla', 'approved', 3),
(34, 'Animal Type: Dog\r\nColor: White with brown patches\r\nSize: Medium\r\nHealth Status: Injured leg, limping badly', '../uploads/reported_pets/R3.jpg', 'Located in a rural area near the entrance to the Diyaluma Falls hiking trail outside Badulla.', 'The dog is sitting near the trail entrance, and hikers reported its injury. Looks like it needs medical attention.', '2024-10-08 17:11:23', 'https://maps.app.goo.gl/UgNPSU2erD7YJ6Gd9', 'Badulla', 'approved', 3),
(35, 'Found a pet near the temple', '../uploads/reported_pets/R3.jpg', 'I do not have an idea', '', '2024-10-08 17:32:22', 'https://maps.app.goo.gl/jvD2giKZdRDea4dMA', 'Matale', 'rejected', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `saved_pets`
--

CREATE TABLE `saved_pets` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `PetID` int(11) NOT NULL,
  `SavedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saved_pets`
--

INSERT INTO `saved_pets` (`ID`, `UserID`, `PetID`, `SavedAt`) VALUES
(10, 1, 35, '2024-10-08 16:59:14');

-- --------------------------------------------------------

--
-- Table structure for table `shelters`
--

CREATE TABLE `shelters` (
  `ShelterID` int(11) NOT NULL,
  `ShelterName` varchar(100) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `PhoneNumber` varchar(15) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `DistrictID` int(11) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shelters`
--

INSERT INTO `shelters` (`ShelterID`, `ShelterName`, `Address`, `PhoneNumber`, `Email`, `DistrictID`, `CreatedAt`, `UpdatedAt`, `Password`) VALUES
(3, 'kandy', 'asdasdSADASD', '67957467474', 'udithaerandake.800@gmail.com', 11, '2024-09-13 06:39:11', '2024-09-21 14:24:25', '$2y$10$POzmOz.HWS2/YmJenGtrl.gN42oTv00/2qYppR5sXLchdNEMccOMK'),
(4, 'Badulla', 'Bambalapitiya', '0759743432', 'badulla@gmail.com', 3, '2024-09-13 17:34:09', '2024-09-13 17:34:09', '$2y$10$oUwfOq2vefhL6wW0BYfVieRx5/GLM.j6AQSpnzR6MONovDbz49/xe'),
(12, 'Colombo', 'bambalapitiya, Colombo', '0112345678', 'colombo@gmail.com', 5, '2024-10-08 06:50:38', '2024-10-08 06:50:38', '$2y$10$AFGQxk1xNVOaxge1O96siet7IOXRkXKUnieWuSHGCUxghhSRZVNny'),
(13, 'Kurunegala', 'Bambalapitiya', '0759743432', 'kurunegala@gmail.com', 14, '2024-10-08 10:41:37', '2024-10-08 10:41:37', '$2y$10$tK1gYLzWvwpXbARmi8W05exM9V6cqBVN.Z7UmWiohHz3LpwhhN89G');

-- --------------------------------------------------------

--
-- Table structure for table `success_stories`
--

CREATE TABLE `success_stories` (
  `StoryID` int(11) NOT NULL,
  `PetID` int(11) DEFAULT NULL,
  `Title` varchar(255) NOT NULL,
  `Story` text NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `success_stories`
--

INSERT INTO `success_stories` (`StoryID`, `PetID`, `Title`, `Story`, `Date`) VALUES
(13, 32, 'Bella Finds Her Forever Home', 'Bella, a golden retriever, had spent most of her life on the streets of Kandy. Rescued by a local shelter, she was malnourished and in desperate need of medical attention. Despite her rough start, Bella’s gentle nature captured the hearts of everyone at the shelter. After weeks of recovery, she met her new family—an older couple who had recently lost their dog of 15 years. They fell in love with Bella’s calm and affectionate personality. Bella now enjoys daily walks in the lush hills around Kandy, and her new family says adopting her has brought back joy to their lives.\r\n\r\n', '2024-10-08 17:13:15'),
(14, 35, 'Lucky’s Leap into Love', 'Lucky, a mixed-breed dog, was found in the aftermath of a storm in Badulla. He had been separated from his previous owner, and no one came forward to claim him. Lucky’s friendly and energetic personality quickly made him a favorite at the shelter. After weeks of waiting, he was finally adopted by a local farmer and his family, who were looking for a companion to help around their property. Lucky now spends his days happily running around the farm, herding sheep, and playing with the children. His new family couldn’t be more thrilled with their loyal and loving new friend.\r\n\r\n', '2024-10-08 17:13:27'),
(15, 36, 'Nala’s Rescue and Revival', 'Nala, a timid calico cat, had been living in the shadows near a temple in Kandy. She was skittish and wary of human interaction, having lived on scraps for most of her life. Rescued by a volunteer, Nala was brought to a shelter where she received care and affection for the first time. After months of slow progress, she started to trust again. One day, a family with a quiet home and two young children came to the shelter looking for a gentle companion. Nala fit perfectly into their lives, and she now enjoys a peaceful, love-filled home where she naps in warm corners and receives endless cuddles from the children.', '2024-10-08 17:13:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `PasswordHash` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `PhoneNumber` varchar(15) DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `ProfilePicture` varchar(255) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `PasswordHash`, `Email`, `PhoneNumber`, `Address`, `ProfilePicture`, `CreatedAt`) VALUES
(1, 'user_1', '$2y$10$B4oXYwxkeD2SA93Q3Ei16.vC3X6uMLU4rdTPNNFgv5twkbNa4J5um', 'rezudiya.900@gmail.com', '134134', 'dvadg', '../uploads/profile_pictures/1.png', '2024-09-13 04:45:36'),
(5, 'user_2', '$2y$10$flRxX7yjJPem6t/Cg16UF.xj4qp/2.FDBEVYtdV7jLNPk0o17S4dO', 'udi@gmail.com', '134134', 'hdudi, iasoid, jdiidij', '../uploads/profile_pictures/User 2.jpg', '2024-09-14 15:19:51');

-- --------------------------------------------------------

--
-- Table structure for table `volunteers`
--

CREATE TABLE `volunteers` (
  `VolunteerID` int(11) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `ReasonForVolunteering` text NOT NULL,
  `Skills` text DEFAULT NULL,
  `ApplicationStatus` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `ApplicationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteers`
--

INSERT INTO `volunteers` (`VolunteerID`, `FirstName`, `LastName`, `Email`, `Phone`, `Address`, `ReasonForVolunteering`, `Skills`, `ApplicationStatus`, `ApplicationDate`) VALUES
(8, 'Uditha ', 'Wijekoon', 'udithaerandake.800@gmail.com', '0112345678', 'D.S.Senanayake Street, Kandy', 'Test 1', 'Test 1', 'Approved', '2024-10-08 05:06:06'),
(11, 'Uditha', 'Wijekoon', 'udithaerandake.800@gmail.com', '+94 712345678', '45 Green Lane, Kandy, Sri Lanka', 'I’ve always had a passion for animals and want to make a positive impact in my community. Volunteering at your shelter will allow me to contribute to the well-being of pets in need.', 'Pet grooming,\r\nOrganizational skills,\r\nFundraising\r\n', 'Approved', '2024-10-08 17:26:40'),
(12, 'Yasiru', 'Liyanage', 'user2@gmail.com', '+94 718765432', '102 Mountain Road, Badulla, Sri Lanka\r\n', 'I want to use my free time to help animals in shelters. I believe every animal deserves care and attention, and I want to be a part of making that happen.', 'Dog walking,\r\nPhotography,\r\nEvent coordination', 'Pending', '2024-10-08 17:27:24'),
(13, 'Priya', 'Jayawardena', 'jaya@gmail.com', '+94 715432789', '23 Orchard Avenue, Colombo, Sri Lanka', 'I have always been an animal lover, and I want to give back by helping care for the pets at your shelter. Volunteering would allow me to support an important cause while learning more about animal care.', 'Veterinary assistance,\r\nSocial media management,\r\nFirst aid for pets', 'Rejected', '2024-10-08 17:28:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `admin_messages`
--
ALTER TABLE `admin_messages`
  ADD PRIMARY KEY (`MessageID`),
  ADD KEY `SenderAdminID` (`SenderAdminID`),
  ADD KEY `ReceiverUserID` (`ReceiverUserID`),
  ADD KEY `ReceiverShelterID` (`ReceiverShelterID`);

--
-- Indexes for table `adoption_applications`
--
ALTER TABLE `adoption_applications`
  ADD PRIMARY KEY (`ApplicationID`),
  ADD KEY `PetID` (`PetID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`DistrictID`),
  ADD UNIQUE KEY `DistrictName` (`DistrictName`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`DonationID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `educational_content`
--
ALTER TABLE `educational_content`
  ADD PRIMARY KEY (`ContentID`),
  ADD KEY `AdminID` (`AdminID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`EventID`),
  ADD KEY `CreatedByAdmin` (`CreatedByAdmin`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`FeedbackID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`MessageID`),
  ADD KEY `SenderUserID` (`SenderUserID`),
  ADD KEY `ReceiverAdminID` (`ReceiverAdminID`),
  ADD KEY `ReceiverShelterID` (`ReceiverShelterID`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_pets`
--
ALTER TABLE `pending_pets`
  ADD PRIMARY KEY (`PendingPetID`),
  ADD KEY `ShelterID` (`ShelterID`);

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`PetID`),
  ADD KEY `fk_shelter` (`ShelterID`);

--
-- Indexes for table `pet_care_locations`
--
ALTER TABLE `pet_care_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `saved_pets`
--
ALTER TABLE `saved_pets`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `PetID` (`PetID`);

--
-- Indexes for table `shelters`
--
ALTER TABLE `shelters`
  ADD PRIMARY KEY (`ShelterID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `DistrictID` (`DistrictID`);

--
-- Indexes for table `success_stories`
--
ALTER TABLE `success_stories`
  ADD PRIMARY KEY (`StoryID`),
  ADD KEY `PetID` (`PetID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `volunteers`
--
ALTER TABLE `volunteers`
  ADD PRIMARY KEY (`VolunteerID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `admin_messages`
--
ALTER TABLE `admin_messages`
  MODIFY `MessageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `adoption_applications`
--
ALTER TABLE `adoption_applications`
  MODIFY `ApplicationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `DistrictID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `DonationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `educational_content`
--
ALTER TABLE `educational_content`
  MODIFY `ContentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `FeedbackID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `MessageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `pending_pets`
--
ALTER TABLE `pending_pets`
  MODIFY `PendingPetID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `PetID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `pet_care_locations`
--
ALTER TABLE `pet_care_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `saved_pets`
--
ALTER TABLE `saved_pets`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `shelters`
--
ALTER TABLE `shelters`
  MODIFY `ShelterID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `success_stories`
--
ALTER TABLE `success_stories`
  MODIFY `StoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `volunteers`
--
ALTER TABLE `volunteers`
  MODIFY `VolunteerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_messages`
--
ALTER TABLE `admin_messages`
  ADD CONSTRAINT `admin_messages_ibfk_1` FOREIGN KEY (`SenderAdminID`) REFERENCES `admins` (`AdminID`) ON DELETE CASCADE,
  ADD CONSTRAINT `admin_messages_ibfk_2` FOREIGN KEY (`ReceiverUserID`) REFERENCES `users` (`UserID`) ON DELETE SET NULL,
  ADD CONSTRAINT `admin_messages_ibfk_3` FOREIGN KEY (`ReceiverShelterID`) REFERENCES `shelters` (`ShelterID`) ON DELETE SET NULL;

--
-- Constraints for table `adoption_applications`
--
ALTER TABLE `adoption_applications`
  ADD CONSTRAINT `adoption_applications_ibfk_1` FOREIGN KEY (`PetID`) REFERENCES `pets` (`PetID`),
  ADD CONSTRAINT `adoption_applications_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE SET NULL;

--
-- Constraints for table `educational_content`
--
ALTER TABLE `educational_content`
  ADD CONSTRAINT `fk_admin` FOREIGN KEY (`AdminID`) REFERENCES `admins` (`AdminID`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`CreatedByAdmin`) REFERENCES `admins` (`AdminID`) ON DELETE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`SenderUserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`ReceiverAdminID`) REFERENCES `admins` (`AdminID`) ON DELETE SET NULL,
  ADD CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`ReceiverShelterID`) REFERENCES `shelters` (`ShelterID`) ON DELETE SET NULL;

--
-- Constraints for table `pending_pets`
--
ALTER TABLE `pending_pets`
  ADD CONSTRAINT `pending_pets_ibfk_1` FOREIGN KEY (`ShelterID`) REFERENCES `shelters` (`ShelterID`);

--
-- Constraints for table `pets`
--
ALTER TABLE `pets`
  ADD CONSTRAINT `fk_shelter` FOREIGN KEY (`ShelterID`) REFERENCES `shelters` (`ShelterID`) ON DELETE CASCADE;

--
-- Constraints for table `saved_pets`
--
ALTER TABLE `saved_pets`
  ADD CONSTRAINT `saved_pets_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `saved_pets_ibfk_2` FOREIGN KEY (`PetID`) REFERENCES `pets` (`PetID`) ON DELETE CASCADE;

--
-- Constraints for table `shelters`
--
ALTER TABLE `shelters`
  ADD CONSTRAINT `shelters_ibfk_1` FOREIGN KEY (`DistrictID`) REFERENCES `districts` (`DistrictID`) ON DELETE CASCADE;

--
-- Constraints for table `success_stories`
--
ALTER TABLE `success_stories`
  ADD CONSTRAINT `success_stories_ibfk_1` FOREIGN KEY (`PetID`) REFERENCES `pets` (`PetID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
