-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2019 at 05:43 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blockchain_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `incidents`
--

CREATE TABLE `incidents` (
  `incident_id` int(10) NOT NULL,
  `reporter_mac_id` varchar(20) DEFAULT NULL,
  `severity` varchar(10) DEFAULT NULL,
  `gps_latitude` varchar(10) DEFAULT NULL,
  `gps_longitude` varchar(10) DEFAULT NULL,
  `date_and_time` datetime DEFAULT NULL,
  `details` varchar(75) DEFAULT NULL,
  `incident_status` varchar(15) DEFAULT 'New Incident'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `incidents`
--

INSERT INTO `incidents` (`incident_id`, `reporter_mac_id`, `severity`, `gps_latitude`, `gps_longitude`, `date_and_time`, `details`, `incident_status`) VALUES
(991, '78:78:78:78:78:78', 'Low', ' 123', ' 123', '2019-04-26 08:16:08', ' Hello										', 'Approved'),
(992, 'B8:27:EB:E6:99:A8', 'High', ' 12.939552', ' 77.615429', '2019-05-02 00:37:10', ' The vehicle collided with another vehicle/object', 'Disapproved'),
(993, 'B8:27:EB:E6:99:A8', 'High', ' 12.939552', ' 77.615429', '2019-05-02 00:38:12', ' The vehicle toppled', 'Approved'),
(994, '78:78:78:78:78:78', 'Low', ' 123', ' 123', '2019-04-26 08:16:08', ' Hello										', 'Disapproved'),
(995, 'B8:27:EB:E6:99:A8', 'High', ' 12.939552', ' 77.615429', '2019-05-02 00:37:10', ' The vehicle collided with another vehicle/object', 'Disapproved'),
(996, 'B8:27:EB:E6:99:A8', 'High', ' 12.939552', ' 77.615429', '2019-05-02 00:38:12', ' The vehicle toppled', 'Disapproved'),
(997, '78:78:78:78:78:78', 'Low', ' 123', ' 123', '2019-04-26 08:16:08', ' Hello										', 'Approved'),
(998, 'B8:27:EB:E6:99:A8', 'High', ' 12.939552', ' 77.615429', '2019-05-02 00:37:10', ' The vehicle collided with another vehicle/object', 'Approved'),
(999, 'B8:27:EB:E6:99:A8', 'High', ' 12.939552', ' 77.615429', '2019-05-02 00:38:12', ' The vehicle toppled', 'Approved'),
(1000, '78:78:78:78:78:78', 'Low', ' 123', ' 123', '2019-04-26 08:16:08', ' Hello										', 'Approved'),
(1001, 'B8:27:EB:E6:99:A8', 'High', ' 12.939552', ' 77.615429', '2019-05-02 00:37:10', ' The vehicle collided with another vehicle/object', 'Approved'),
(1002, 'B8:27:EB:E6:99:A8', 'High', ' 12.939552', ' 77.615429', '2019-05-02 00:38:12', ' The vehicle toppled', 'Approved'),
(1003, '78:78:78:78:78:78', 'Low', ' 123', ' 123', '2019-04-26 08:16:08', ' Hello										', 'Approved'),
(1004, 'B8:27:EB:E6:99:A8', 'High', ' 12.939552', ' 77.615429', '2019-05-02 00:37:10', ' The vehicle collided with another vehicle/object', 'Approved'),
(1005, 'B8:27:EB:E6:99:A8', 'High', ' 12.939552', ' 77.615429', '2019-05-02 00:38:12', ' The vehicle toppled', 'Approved'),
(1006, '78:78:78:78:78:78', 'Low', ' 123', ' 123', '2019-04-26 08:16:08', ' Hello										', 'Approved'),
(1007, 'B8:27:EB:E6:99:A8', 'High', ' 12.939552', ' 77.615429', '2019-05-02 00:37:10', ' The vehicle collided with another vehicle/object', 'Approved'),
(1008, 'B8:27:EB:E6:99:A8', 'High', ' 12.939552', ' 77.615429', '2019-05-02 00:38:12', ' The vehicle toppled', 'Approved'),
(1009, '78:78:78:78:78:78', 'Low', ' 123', ' 123', '2019-04-26 08:16:08', ' Hello										', 'Disapproved'),
(1010, 'B8:27:EB:E6:99:A8', 'High', ' 12.939552', ' 77.615429', '2019-05-02 00:37:10', ' The vehicle collided with another vehicle/object', 'Disapproved'),
(1011, 'B8:27:EB:E6:99:A8', 'High', ' 12.939552', ' 77.615429', '2019-05-02 00:38:12', ' The vehicle toppled', 'Disapproved');

-- --------------------------------------------------------

--
-- Table structure for table `user_information`
--

CREATE TABLE `user_information` (
  `email_id` varchar(40) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `mac_id` varchar(20) DEFAULT NULL,
  `registration_no` varchar(20) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `reputation` int(5) DEFAULT '100',
  `wallet_balance` int(10) DEFAULT '100',
  `public_key` longtext,
  `private_key` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_information`
--

INSERT INTO `user_information` (`email_id`, `name`, `mac_id`, `registration_no`, `password`, `reputation`, `wallet_balance`, `public_key`, `private_key`) VALUES
('berti.harry18@gmail.com', 'Berti Harry', '98:87:76:65:54:43', 'KA-01-MK-5336', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 100, 100, '30819f300d06092a864886f70d010101050003818d0030818902818100a984284e8d3b5fdbd9ef20267b40c4564b0a447dc568914655a1cb5781e4df77d2c861ce9011b9b6ff3cfc610bbf38308772eb32dd1cacbce2e3aefd4a3d0c651e417eb6d594f9c752d86e35127c54ec487c8f8213d7c323bcb2af1627cfd4f04e0fff4cf5a2cead13c7f93a04e137a53e2832f0bbd1e9ac3c3f3ba5566103d30203010001', '3082025b02010002818100a984284e8d3b5fdbd9ef20267b40c4564b0a447dc568914655a1cb5781e4df77d2c861ce9011b9b6ff3cfc610bbf38308772eb32dd1cacbce2e3aefd4a3d0c651e417eb6d594f9c752d86e35127c54ec487c8f8213d7c323bcb2af1627cfd4f04e0fff4cf5a2cead13c7f93a04e137a53e2832f0bbd1e9ac3c3f3ba5566103d30203010001027f54c1bf65873828b5c441cbd171cef05c3528ed15f59e5304d7cc0ddfb312bca92cbb042c43dc98fee69f9790ee4eadc995efdfa98ee4c779a9f82d8677980e99af1c85ea9649d5322685c7220588543cdcbcb30058359597abad76fe78f56c581d9ec1e8b75e306ceece19ac52b2f05ca59ead0c6d57e33b9ab93791e24401024100bbfe10d30c0efde75f9febf252a6ec11adb75aeec7907183682335b7b3f01dc6b4786aa8ed1c10765bb138e247e4a6499c970ea605a893a7bf972916c060b06f024100e6d703d5911d24e7fbc8a6f32680b55038d2151935db7605d205340693f7ec8e85a9d59515f8eea079a0af62e43e0b3c759a7ef48160b4dd80be6df862548cdd024100a2112709fae455ca092b426af70c4689fb1c0e3dba37f1545b0bb7bcb658742320e48af734eab3da85b3e41957e76be01c2a320bb8e71adc4c1491ecb64ee4eb024100c87234b62288381fe916d7419451771fedf71eb3017d4c02c9d812d11373d949f8eefcb3b49cb03950e422e7b061dfc7e426ffceb8f98c943ad32112e9ef995102400884935ac2dc51bd845c0e13c460f39c074ed1ba46a2fa7c8e8207cfc5da32151f88bc5ee619a6d68d5f505766f8b1988ee3544c6f531504f1dabe6df6fb32d8'),
('harry@gmail.com', 'Harry', '89:89:89:89:89:89', 'KA-89-89-89', '356a192b7913b04c54574d18c28d46e6395428ab', 100, 100, '30819f300d06092a864886f70d010101050003818d0030818902818100bfa400a166c75272c4c93d408269f30a1169f07ba16ce62624cb5cba70095500f3bda78c9da68550f31c157eb49a107d84b8490730da2e85116bfc91842db58e8b0fbd8f413b9fb2d5863227405b420cf53af53b913020eb517166e7d6e7e75fa41dd054da1f4a6c623d0c05d5ba6b824c8fd76086e97a219da4f4802969ec4b0203010001', '3082025c02010002818100bfa400a166c75272c4c93d408269f30a1169f07ba16ce62624cb5cba70095500f3bda78c9da68550f31c157eb49a107d84b8490730da2e85116bfc91842db58e8b0fbd8f413b9fb2d5863227405b420cf53af53b913020eb517166e7d6e7e75fa41dd054da1f4a6c623d0c05d5ba6b824c8fd76086e97a219da4f4802969ec4b0203010001028181009d6f0eb1896cafb7e71fe738eaaa3d6604fe41f85e99c6cc8927a3aae9c550d6b2661891f5254a9a40cdce7ec3c15950b44a6c7c02cf0aae78ac7cd5d27f768911a45cdcc24577479676a4fe0e242b271b748df16ca06cf049ef0c9f8d76cc6e32ec4a5441c832582d685a49e2034de6be74451647f5ebb067dbafcde1f00c31024100cdfa7ea3ae960c55371264f8023eb051044b9d86eb8612d8fb6757c375ff2257cf244149a55ce3603603c317f879d7e7e52d2d0b02b6be75a26c55bd4a8c5829024100ee2e22a809c1a2f4f20747216dcfd6784caffb3f1307310cd70b190b32333558b4e68d5a69b8e597d849960ff369fe084011228e04d3c638ae764c3ca6657f530240425e8d81b65698e0b85f0ff3addd7f388bb6c5aa5ca795d91ea0bcf1b94a9d4947f079acfe4080ef56583dfbb24fa8570b4c5430310eab2e024900137f3adb8902406e6c9544b2c1437bac7a13503c490f75d6980033cdee979f0c53e8d877fda5cdea90b91821cbc7260ef08ed1f6583d9e3595bc1f7bbd7338f429844eda16546102404dbeec18a4e362427c87f6988771e35cd257ff39bfdba6089b87fb2c362c9454d2e69571e9b16cc964a4942693de95f72057e8128f6f14673b6c82aa484ccbab'),
('harryroshan1997@gmail.com', 'Harry Roshan', 'B8:27:EB:E6:99:A8', 'KA-01-MK-5000', '3844d93eefd1ae81af400016ab7da12d958bd005', 80, 110, '30819f300d06092a864886f70d010101050003818d0030818902818100b38dad7c49d398d8a48adb702d1c29f13bfb981a6cdc5366218649138e3f547e37862cab98dc256a19525ac354c58c74ea7e7ed5b93a8223a335a25503e409f9981ea9762e17b7d28ddf8baac2ab806651bb2a309f337def988fb120c14a9cbc65d999845dc98b0368ab6e80129c5fac46db08f7ba5fad6bf17d3cf4973b9e730203010001', '3082025d02010002818100b38dad7c49d398d8a48adb702d1c29f13bfb981a6cdc5366218649138e3f547e37862cab98dc256a19525ac354c58c74ea7e7ed5b93a8223a335a25503e409f9981ea9762e17b7d28ddf8baac2ab806651bb2a309f337def988fb120c14a9cbc65d999845dc98b0368ab6e80129c5fac46db08f7ba5fad6bf17d3cf4973b9e7302030100010281805aba909b6942becd59f7c082a288c4b8dd3278dd817ca3b7cbe0eb343280d5d521816f391678c77f216477f093f96ecbf5620dfd3927d372e699c7796609e8ef98c86a96f3bfa326f03b2abd68d075518a4e281eb6554a53f3c715b4348cb91cfc6e05dc2dc11b17b41f30016ae334fbd0c399a0c7617b305888249c44e7fe41024100c323abdec651b2016b1388c8c6c77b87f930e3bdebf9259425c10aa98101fb22b9f1abd9a5938aa3e61f88554c204ed801c7b4698ad8f033a30b4baa97dfc499024100eb8d9844257523ea2801a3251e42d6cf91781aff189eae3f72b8cee2c76f550e5b944c749c17e0945483455ebb70d799d0816c7473797c1da776f168d87516eb024100a274700166d95c7811cc917395093dae55a67df2ff20cc4829a62c5a312c9506b4069e2af3cd80fe31f6ce693497310c636efea35f147be4813846261f8a0b010240691db0fb8833b429445d26aee3c8341040fc761fac9ef367810c93d683e55cf1a15096a5db1a94afdcdf0fcfec99b8bcfd5d2446fb5915582e6957e5cfe2c0ad0241009705aac78fcbf42d1842d551d8907ec52dbe7eae7c4f1f93172d38c401a50afafc9fd2c07c55190f69f997d5fa9c7f2d486dead34fcae0059fe6175660051cad'),
('manoj@gmail.com', 'Manoj Sappan', '78:78:78:78:78:78', 'KA-99-99-9999', '356a192b7913b04c54574d18c28d46e6395428ab', 90, 100, '30819f300d06092a864886f70d010101050003818d0030818902818100bbca50a5210ad3ed3d70f18a74fde99f9c6fb145863f0e16b8c1f3427388307dcf1a192fdd81945191cb467f821be64c7aeca538b65326f46b121dd62fda39e56e42b94a8afc7edbddfa9e8cdcf74fc4e7b48f116ea9b2df47410e44f1b3ce66acf2bbc8e82a56b326e0b4d8aa6c537a24bb1011a9ca089087230e13e7e35a1b0203010001', '3082025d02010002818100bbca50a5210ad3ed3d70f18a74fde99f9c6fb145863f0e16b8c1f3427388307dcf1a192fdd81945191cb467f821be64c7aeca538b65326f46b121dd62fda39e56e42b94a8afc7edbddfa9e8cdcf74fc4e7b48f116ea9b2df47410e44f1b3ce66acf2bbc8e82a56b326e0b4d8aa6c537a24bb1011a9ca089087230e13e7e35a1b02030100010281810081ce4e42667daa9241b7316f28815f1cf2308e93e540eec72bfcfcde8127b1853543f0071310ffea0662419fdfdad32d28872d89ef15b946984054997a48595d992d3eb79905cc79863313c6abf690412b87a7b87a1727133ccb82c7e66fb51ea9b80b0ba27ded421ef2cf6eac76060d561ca4ebe37a65718ddd46a846d69501024100bfd0610517674d6aaf3e799e34c527afa0a714585dc6bf833b2569faec2a8837e4d2d035523a52b7f509cdfce7feb3d855213528196a38087c71de80f54b1281024100faa13fdc06b7cc2f1f87b53bf723eb9584d92a743f8124007ea6bd74ef4d290e10165ab0a6e058b3bc492ff0f5133294ba4d59b9b6c42388eed2694a86b0269b02410085795749d7b346a7ca324b26cfc9b18800dec2c58adbd6405753fd9f61df66d29e2424463665e751a2eda3ad2d328bab29f1e5af759ff845cf72dd46176a9a01024034b7a0300eb5b05c251cad715c8d90ab15937c4b9163ff879f1c41738c3645b1708ed32a9f1f47691eeca209e3f2d2cbd7d8174c69f61da75adca54b08c39a8b02403880f3cc5311f1ce16d9634c8641f60e080d779d6f832faf46663120f5578dbd3a12fc55ba5385c7e16270e61762d5fc83088843d7f89a60c96a42d159416eb0'),
('manoj@yahoo.com', 'Manoj M Sappan', '12:00:12:00:12:00', 'KA-01-BB-5001', 'e5bed78df35c9a68cd0ebc89592def76df34c305', 100, 100, '30819f300d06092a864886f70d010101050003818d0030818902818100be7644626a67dcf0f14c7784a43496f294d87222c1316fd0371502c2d1cf24bb8446e16f8a4484ba68e32fc51c997ef5495d0debfbbe3c9269a2c74eba0dcdcfe9868a6654622a49703165ea4d530c3287e863bb78bbd15cb84d0638db8de8d2e54bd331c7c94e39cbd74ef9edac44ce862d9b72bdda306a8c8cf3820331f8a30203010001', '3082025c02010002818100be7644626a67dcf0f14c7784a43496f294d87222c1316fd0371502c2d1cf24bb8446e16f8a4484ba68e32fc51c997ef5495d0debfbbe3c9269a2c74eba0dcdcfe9868a6654622a49703165ea4d530c3287e863bb78bbd15cb84d0638db8de8d2e54bd331c7c94e39cbd74ef9edac44ce862d9b72bdda306a8c8cf3820331f8a302030100010281800c21602d9c754cff137f39457b67d60d51298feb62be914e839394ff6f796fef79774238666802c41496139ecc39827a80d7aa615341447e56b80555a047ecc9aac20fc96d59e8b700620f0d1d416c77d6ac66b547b83f9b3e82394a13809ae7c97e21d940b2180ba401e814c8c8f0f0fd617481a11244673142a44b7808f941024100c03c3d3ec70e3e8f409b3113c82124114b2bf8b83ffcd6778d48a8fcfeeff79c41898dfe9201b4cfb040f288522ae15476b688574f1c87ece8a0f3979111b7b1024100fda371dcc7a24c937ab6fe0ecde6da6fcb80988a5f0bcf229d9e3287406c7bccc19239f3e1cb7aa45eb65efa33bf9898374dbe670502c0134fa96b9bacdade930241008f7c2726b5833f54c39f52b97636ae6a2e16cb1613c4cffbfa3bd2cecc272745bd7143c85108ef01da880fbf8abd30e54f9a9d17b61810a8d756539bbd0f6171024022c3ff7c6aa4b568559eb58e23ecebadfd2fe038bf34682cef7bdaa32d527159ac82b58cd73b43d139e63778861551fe333e65c5cb2b0856dd4974a57ef8f51f0240730dc9c4f172a2e5c638764a2aaf756f7161a8a843879ee390a40d141a48fde41439fa46676c779329ad2ffd02c1a9395817fd28eb5b0c8e319cc259570ea6e4'),
('shivangi@gmail.com', 'Shivangi', '99:99:99:99:99:99', 'KA-10-10-1010', '356a192b7913b04c54574d18c28d46e6395428ab', 100, 100, '30819f300d06092a864886f70d010101050003818d0030818902818100c6806288114c5d9d59173f29665acd2a082254af6e6304093537f182a8ae88d6b95c9541718c290263e51e24d1fef174aac484eb302e43d81eeacc3e44dc481df5fdbd9d401c76ef8af97e7a4223eba6c5481c68f7d3c6cca26fcab936fbe308ca9adf387fcb27a4acec124d8f4560e9436c9d4d88fe55ec9e1e5f12b6e8479d0203010001', '3082025c02010002818100c6806288114c5d9d59173f29665acd2a082254af6e6304093537f182a8ae88d6b95c9541718c290263e51e24d1fef174aac484eb302e43d81eeacc3e44dc481df5fdbd9d401c76ef8af97e7a4223eba6c5481c68f7d3c6cca26fcab936fbe308ca9adf387fcb27a4acec124d8f4560e9436c9d4d88fe55ec9e1e5f12b6e8479d020301000102818042fba1c42eaa2950e6765cbef8a61d635899552059cc99d90d97522cf804e57227dca115135eeb9bbddfdbdb2aedafc6e1b52cf13c31f07ce679eeeff846a922b2440f28d565d8e17138e8b2f592e2cdc25923974c55874126349edce1911fd2de7796bc4001d1ceac061e26d42d3b5ab799f994d2b6122214c3c03942272195024100cd08c10dfc3aa867c234ef1c27d2fc26fc74273643901a7e2fadf6ad04b70eb6b14620d20821827c10ffbf59b31660bb6245a180e2ac9b7e5fe076ea615143c7024100f7d7ed1e61efc983c428141c0359f8cf6cb26964341053cd1b1e7815502b52c09355d165ea2e89c0bdab4fdfbfc0aa4389d6d48c4bcf12c990f407a7c4bf917b024013d01dbfb938fddf10f0468ee4f649718701be6c4af918e64abb37d41e59862d7751fc87ef4b35adc182c53de8c567d193bc80cfd097b76aeddee5fede2a992f0240271f3d7dc345df905e215973469028374dd827ccba6f2d5b3e01a440f103b5af525284984acc07d095dff9debedd01c36179b8d9608a125420fe744ae642bb0b024100b7a325ea34f274824d73f8e4d79c57b2387cf67ea9befaca4db2d12c4960bb8377e04e6b62bd200f4ff79d4c002bcc5f6144ffc9681bab49f876cbfbffa325aa'),
('sunkeerth@yahoo.com', 'Sunkeerth Kumar 2', '12:21:12:21:12:12', 'KA-01-AA-0002', '77de68daecd823babbb58edb1c8e14d7106e83bb', 100, 100, '30819f300d06092a864886f70d010101050003818d0030818902818100dfea4dddcd97bdfaa29ab8ba7fcd2ced7399696a66359f8887b5291824f794c1a01772446905d5f8c99d5ecbe61ccc800a4b5febf35232bd2809eef554c9c619bc6f96786ba2442d852294139c75189f1389eff724a0e2cecc1a06cddaf0d92cd309e7bdafa0bb3a2ffc4299c2fe88269eab5a2b2eee9b3eb4e0e4f306dbd4750203010001', '3082025f02010002818100dfea4dddcd97bdfaa29ab8ba7fcd2ced7399696a66359f8887b5291824f794c1a01772446905d5f8c99d5ecbe61ccc800a4b5febf35232bd2809eef554c9c619bc6f96786ba2442d852294139c75189f1389eff724a0e2cecc1a06cddaf0d92cd309e7bdafa0bb3a2ffc4299c2fe88269eab5a2b2eee9b3eb4e0e4f306dbd475020301000102818100cf70b700b4964ec7a2daea26c57da490bb56b6057f795039e157a121a025ca27739425256192a97f99f0f440bc0794214ee8338e59569e710565e67e5c35ae12af97225f9bb38c7c2801bd7342a042390671073a623fe8e9ae39565e2bd7e2e4a49b50ace176976084905da9c360dec3d447bec8a50e42546ff3bfd9c11417e1024100e464d7a2c602f0cbafadcdfaa577c5e890c3add0e2161c02ca96566863f5a78f1c3aeabd71980d2acccb36d2ad2e2aa9610d021f465b9ca2260b13f19e9c0d99024100fafae113c35165a3f873efe1db19961ea1eefea03e41c910167fdcbd01559b8e3defc3fb40f31e2960b33e710fc5f9aeff9d1764fd4f9b2a117af0d43409af3d0241009f6c4ca0d03ae93e2488db88a3cbb1179f4517a500cb920dd8bf8bdd1e393116d20bc6232a918a4f5fd8519249543a6f34d151b3e6f6b7a4ef8d3804a64423b1024100de3e23eaed2cf9d50de0140e2a86e8b0ed7205957e2ba0d0972bd81aa1c0ddc342433b8714877430edc92b44d0d3dd7a422d28172c5c3ea92cdb71c066e8207d024100db0075a1826c43ce4950ee99fddc94316deadffd678d8ad6273ab8b8f980b00a25b1f03e765f5609bd4df437f292e845e2ce3c2351cf8942433ad08eee8b2834');

-- --------------------------------------------------------

--
-- Table structure for table `vote_information`
--

CREATE TABLE `vote_information` (
  `incident_id` int(10) NOT NULL,
  `mac_id` varchar(20) NOT NULL,
  `vote_status` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vote_information`
--

INSERT INTO `vote_information` (`incident_id`, `mac_id`, `vote_status`) VALUES
(991, '12:00:12:00:12:00', 'Not Voted Yet'),
(991, '12:21:12:21:12:12', 'Not Voted Yet'),
(991, '78:78:78:78:78:78', 'Not Voted Yet'),
(991, '89:89:89:89:89:89', 'Not Voted Yet'),
(991, '98:87:76:65:54:43', 'Not Voted Yet'),
(991, '99:99:99:99:99:99', 'Not Voted Yet'),
(991, 'B8:27:EB:E6:99:A8', 'Upvoted'),
(992, '12:00:12:00:12:00', 'Not Voted Yet'),
(992, '12:21:12:21:12:12', 'Not Voted Yet'),
(992, '78:78:78:78:78:78', 'Not Voted Yet'),
(992, '89:89:89:89:89:89', 'Not Voted Yet'),
(992, '98:87:76:65:54:43', 'Not Voted Yet'),
(992, '99:99:99:99:99:99', 'Not Voted Yet'),
(992, 'B8:27:EB:E6:99:A8', 'Downvoted'),
(993, '12:00:12:00:12:00', 'Not Voted Yet'),
(993, '12:21:12:21:12:12', 'Not Voted Yet'),
(993, '78:78:78:78:78:78', 'Not Voted Yet'),
(993, '89:89:89:89:89:89', 'Not Voted Yet'),
(993, '98:87:76:65:54:43', 'Not Voted Yet'),
(993, '99:99:99:99:99:99', 'Not Voted Yet'),
(993, 'B8:27:EB:E6:99:A8', 'Upvoted'),
(994, '12:00:12:00:12:00', 'Not Voted Yet'),
(994, '12:21:12:21:12:12', 'Not Voted Yet'),
(994, '78:78:78:78:78:78', 'Not Voted Yet'),
(994, '89:89:89:89:89:89', 'Not Voted Yet'),
(994, '98:87:76:65:54:43', 'Not Voted Yet'),
(994, '99:99:99:99:99:99', 'Not Voted Yet'),
(994, 'B8:27:EB:E6:99:A8', 'Downvoted'),
(995, '12:00:12:00:12:00', 'Not Voted Yet'),
(995, '12:21:12:21:12:12', 'Not Voted Yet'),
(995, '78:78:78:78:78:78', 'Not Voted Yet'),
(995, '89:89:89:89:89:89', 'Not Voted Yet'),
(995, '98:87:76:65:54:43', 'Not Voted Yet'),
(995, '99:99:99:99:99:99', 'Not Voted Yet'),
(995, 'B8:27:EB:E6:99:A8', 'Downvoted'),
(996, '12:00:12:00:12:00', 'Not Voted Yet'),
(996, '12:21:12:21:12:12', 'Not Voted Yet'),
(996, '78:78:78:78:78:78', 'Not Voted Yet'),
(996, '89:89:89:89:89:89', 'Not Voted Yet'),
(996, '98:87:76:65:54:43', 'Not Voted Yet'),
(996, '99:99:99:99:99:99', 'Not Voted Yet'),
(996, 'B8:27:EB:E6:99:A8', 'Downvoted'),
(997, '12:00:12:00:12:00', 'Not Voted Yet'),
(997, '12:21:12:21:12:12', 'Not Voted Yet'),
(997, '78:78:78:78:78:78', 'Not Voted Yet'),
(997, '89:89:89:89:89:89', 'Not Voted Yet'),
(997, '98:87:76:65:54:43', 'Not Voted Yet'),
(997, '99:99:99:99:99:99', 'Not Voted Yet'),
(997, 'B8:27:EB:E6:99:A8', 'Upvoted'),
(998, '12:00:12:00:12:00', 'Not Voted Yet'),
(998, '12:21:12:21:12:12', 'Not Voted Yet'),
(998, '78:78:78:78:78:78', 'Not Voted Yet'),
(998, '89:89:89:89:89:89', 'Not Voted Yet'),
(998, '98:87:76:65:54:43', 'Not Voted Yet'),
(998, '99:99:99:99:99:99', 'Not Voted Yet'),
(998, 'B8:27:EB:E6:99:A8', 'Upvoted'),
(999, '12:00:12:00:12:00', 'Not Voted Yet'),
(999, '12:21:12:21:12:12', 'Not Voted Yet'),
(999, '78:78:78:78:78:78', 'Not Voted Yet'),
(999, '89:89:89:89:89:89', 'Not Voted Yet'),
(999, '98:87:76:65:54:43', 'Not Voted Yet'),
(999, '99:99:99:99:99:99', 'Not Voted Yet'),
(999, 'B8:27:EB:E6:99:A8', 'Upvoted'),
(1000, '12:00:12:00:12:00', 'Not Voted Yet'),
(1000, '12:21:12:21:12:12', 'Not Voted Yet'),
(1000, '78:78:78:78:78:78', 'Not Voted Yet'),
(1000, '89:89:89:89:89:89', 'Not Voted Yet'),
(1000, '98:87:76:65:54:43', 'Not Voted Yet'),
(1000, '99:99:99:99:99:99', 'Not Voted Yet'),
(1000, 'B8:27:EB:E6:99:A8', 'Upvoted'),
(1001, '12:00:12:00:12:00', 'Not Voted Yet'),
(1001, '12:21:12:21:12:12', 'Not Voted Yet'),
(1001, '78:78:78:78:78:78', 'Not Voted Yet'),
(1001, '89:89:89:89:89:89', 'Not Voted Yet'),
(1001, '98:87:76:65:54:43', 'Not Voted Yet'),
(1001, '99:99:99:99:99:99', 'Not Voted Yet'),
(1001, 'B8:27:EB:E6:99:A8', 'Upvoted'),
(1002, '12:00:12:00:12:00', 'Not Voted Yet'),
(1002, '12:21:12:21:12:12', 'Not Voted Yet'),
(1002, '78:78:78:78:78:78', 'Not Voted Yet'),
(1002, '89:89:89:89:89:89', 'Not Voted Yet'),
(1002, '98:87:76:65:54:43', 'Not Voted Yet'),
(1002, '99:99:99:99:99:99', 'Not Voted Yet'),
(1002, 'B8:27:EB:E6:99:A8', 'Upvoted'),
(1003, '12:00:12:00:12:00', 'Not Voted Yet'),
(1003, '12:21:12:21:12:12', 'Not Voted Yet'),
(1003, '78:78:78:78:78:78', 'Not Voted Yet'),
(1003, '89:89:89:89:89:89', 'Not Voted Yet'),
(1003, '98:87:76:65:54:43', 'Not Voted Yet'),
(1003, '99:99:99:99:99:99', 'Not Voted Yet'),
(1003, 'B8:27:EB:E6:99:A8', 'Upvoted'),
(1004, '12:00:12:00:12:00', 'Not Voted Yet'),
(1004, '12:21:12:21:12:12', 'Not Voted Yet'),
(1004, '78:78:78:78:78:78', 'Not Voted Yet'),
(1004, '89:89:89:89:89:89', 'Not Voted Yet'),
(1004, '98:87:76:65:54:43', 'Not Voted Yet'),
(1004, '99:99:99:99:99:99', 'Not Voted Yet'),
(1004, 'B8:27:EB:E6:99:A8', 'Upvoted'),
(1005, '12:00:12:00:12:00', 'Not Voted Yet'),
(1005, '12:21:12:21:12:12', 'Not Voted Yet'),
(1005, '78:78:78:78:78:78', 'Not Voted Yet'),
(1005, '89:89:89:89:89:89', 'Not Voted Yet'),
(1005, '98:87:76:65:54:43', 'Not Voted Yet'),
(1005, '99:99:99:99:99:99', 'Not Voted Yet'),
(1005, 'B8:27:EB:E6:99:A8', 'Upvoted'),
(1006, '12:00:12:00:12:00', 'Not Voted Yet'),
(1006, '12:21:12:21:12:12', 'Not Voted Yet'),
(1006, '78:78:78:78:78:78', 'Not Voted Yet'),
(1006, '89:89:89:89:89:89', 'Not Voted Yet'),
(1006, '98:87:76:65:54:43', 'Not Voted Yet'),
(1006, '99:99:99:99:99:99', 'Not Voted Yet'),
(1006, 'B8:27:EB:E6:99:A8', 'Upvoted'),
(1007, '12:00:12:00:12:00', 'Not Voted Yet'),
(1007, '12:21:12:21:12:12', 'Not Voted Yet'),
(1007, '78:78:78:78:78:78', 'Not Voted Yet'),
(1007, '89:89:89:89:89:89', 'Not Voted Yet'),
(1007, '98:87:76:65:54:43', 'Not Voted Yet'),
(1007, '99:99:99:99:99:99', 'Not Voted Yet'),
(1007, 'B8:27:EB:E6:99:A8', 'Upvoted'),
(1008, '12:00:12:00:12:00', 'Not Voted Yet'),
(1008, '12:21:12:21:12:12', 'Not Voted Yet'),
(1008, '78:78:78:78:78:78', 'Not Voted Yet'),
(1008, '89:89:89:89:89:89', 'Not Voted Yet'),
(1008, '98:87:76:65:54:43', 'Not Voted Yet'),
(1008, '99:99:99:99:99:99', 'Not Voted Yet'),
(1008, 'B8:27:EB:E6:99:A8', 'Upvoted'),
(1009, '12:00:12:00:12:00', 'Not Voted Yet'),
(1009, '12:21:12:21:12:12', 'Not Voted Yet'),
(1009, '78:78:78:78:78:78', 'Not Voted Yet'),
(1009, '89:89:89:89:89:89', 'Not Voted Yet'),
(1009, '98:87:76:65:54:43', 'Not Voted Yet'),
(1009, '99:99:99:99:99:99', 'Not Voted Yet'),
(1009, 'B8:27:EB:E6:99:A8', 'Downvoted'),
(1010, '12:00:12:00:12:00', 'Not Voted Yet'),
(1010, '12:21:12:21:12:12', 'Not Voted Yet'),
(1010, '78:78:78:78:78:78', 'Not Voted Yet'),
(1010, '89:89:89:89:89:89', 'Not Voted Yet'),
(1010, '98:87:76:65:54:43', 'Not Voted Yet'),
(1010, '99:99:99:99:99:99', 'Not Voted Yet'),
(1010, 'B8:27:EB:E6:99:A8', 'Downvoted'),
(1011, '12:00:12:00:12:00', 'Not Voted Yet'),
(1011, '12:21:12:21:12:12', 'Not Voted Yet'),
(1011, '78:78:78:78:78:78', 'Not Voted Yet'),
(1011, '89:89:89:89:89:89', 'Not Voted Yet'),
(1011, '98:87:76:65:54:43', 'Not Voted Yet'),
(1011, '99:99:99:99:99:99', 'Not Voted Yet'),
(1011, 'B8:27:EB:E6:99:A8', 'Downvoted');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `incidents`
--
ALTER TABLE `incidents`
  ADD PRIMARY KEY (`incident_id`),
  ADD KEY `reporter_mac_id` (`reporter_mac_id`);

--
-- Indexes for table `user_information`
--
ALTER TABLE `user_information`
  ADD PRIMARY KEY (`email_id`),
  ADD UNIQUE KEY `mac_id` (`mac_id`),
  ADD UNIQUE KEY `registration_no` (`registration_no`);

--
-- Indexes for table `vote_information`
--
ALTER TABLE `vote_information`
  ADD PRIMARY KEY (`incident_id`,`mac_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `incidents`
--
ALTER TABLE `incidents`
  MODIFY `incident_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1012;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `incidents`
--
ALTER TABLE `incidents`
  ADD CONSTRAINT `incidents_ibfk_1` FOREIGN KEY (`reporter_mac_id`) REFERENCES `user_information` (`mac_id`);

--
-- Constraints for table `vote_information`
--
ALTER TABLE `vote_information`
  ADD CONSTRAINT `vote_information_ibfk_1` FOREIGN KEY (`incident_id`) REFERENCES `incidents` (`incident_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
