CREATE TABLE `Users` (
  `email` varchar(255) PRIMARY KEY,
  `password` varchar(255),
  `userName` varchar(255)
);

CREATE TABLE `Posts` (
  `postId` integer PRIMARY KEY,
  `ownerEmail` varchar(255),
  `folderId` integer,
  `postName` varchar(255),
  `postDescription` varchar(255),
  `created` date
);

CREATE TABLE `Folders` (
  `folderId` integer PRIMARY KEY,
  `ownerEmail` varchar(255),
  `folderName` varchar(255),
  `created` date
);

CREATE TABLE `Tags` (
  `tagId` integer PRIMARY KEY,
  `tagName` varchar(255)
);

CREATE TABLE `PostTags` (
  `postTagsId` integer PRIMARY KEY,
  `postId` integer,
  `tagId` integer
);

CREATE TABLE `SharedPosts` (
  `sharedPostsId` integer PRIMARY KEY,
  `postId` integer,
  `sharedTo` varchar(255)
);

CREATE TABLE `SharedFolders` (
  `SharedFoldersId` integer PRIMARY KEY,
  `folderId` integer,
  `sharedTo` varchar(255)
);

ALTER TABLE `Posts` ADD FOREIGN KEY (`ownerEmail`) REFERENCES `Users` (`email`);

ALTER TABLE `Posts` ADD FOREIGN KEY (`folderId`) REFERENCES `Folders` (`folderId`);

ALTER TABLE `Folders` ADD FOREIGN KEY (`ownerEmail`) REFERENCES `Users` (`email`);

ALTER TABLE `PostTags` ADD FOREIGN KEY (`postId`) REFERENCES `Posts` (`postId`);

ALTER TABLE `PostTags` ADD FOREIGN KEY (`tagId`) REFERENCES `Tags` (`tagId`);

ALTER TABLE `SharedPosts` ADD FOREIGN KEY (`postId`) REFERENCES `Posts` (`postId`);

ALTER TABLE `SharedPosts` ADD FOREIGN KEY (`sharedTo`) REFERENCES `Users` (`email`);

ALTER TABLE `SharedFolders` ADD FOREIGN KEY (`folderId`) REFERENCES `Folders` (`folderId`);

ALTER TABLE `SharedFolders` ADD FOREIGN KEY (`sharedTo`) REFERENCES `Users` (`email`);
