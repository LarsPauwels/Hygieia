# Resource Overview
The following resources are accessible via the REST API or are concepts core to the Hygieia App that you should familiarize yourself with.

### Authentication
This contains the core features of an REST API such as login, logout, change password, .... These always link back to the user object.

### Users
This object contains the Admin user but also the payed clients. If a client pays for Hygieia services they get access to and account, with limited capabilities.

### Clients
An User is the master record for a Business that uses Hygieia. All created items will be linked to the corresponding client.

### Spaces
Spaces is linked to the Item object but also to the client object. These are the spaces created by the client that needs to be cleaned.

### Items
This object is where everything is connected to. The client will created items in a space, so that the cleaner knows wich item needs to be cleaned.

### Payments
A client can pay to get access to certain functionalities in the Hygieia app. When payed they get an account in the user object.

### PDF
The PDF end-points will create downloadable files. So that the client can print this for there cleaners. You can print for one day, but also for a month or the whole year.

### Products
The products is linked with a many to many relation to the item object. So that the cleaner knows wich cleaning material they can use.

### Frequencies
Frequencies is linked to the Item object. So that the cleaner knows how often the corresponding item needs to be cleaned.

### Icons
All the icon paths for the products and items will be saved here. Divided by the type of the icon it self.

### Producers
Producers is also linked to the Item object. So that the cleaner knows how the object needs to be cleand. If there are special procedures or not.