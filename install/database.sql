CREATE DATABASE oAuthServer
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;
GRANT USAGE ON *.* to perseids@localhost identified by 'perseids';
GRANT ALL PRIVILEGES ON oAuthServer.* to perseids@localhost ;