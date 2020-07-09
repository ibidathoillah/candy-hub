# 0.2.48

- [improved] Improved slug generation when duplicating products

# 0.2.47

- [improved] Minor misc improvements to customer edit screen.

# 0.2.46

- [fixed] Fixed wrong reference to save dispatch on nested category tab

# 0.2.45

- [fixed] Fixed logic and console error on customer edit screen
- [improved] Improved way customer fields are generated on customer edit screen.

# 0.2.44

- [fixed] Fixed video URLs on media

# 0.2.43

- [fixed] Removed deprecated `fire` method

# 0.2.42

[added] #20

# 0.2.41

- [added] Added duplicate product screens

# 0.2.40

- [improved] Updated Axios
- [changed] Set primary value to int when setting asset attributes

# 0.2.39

- [improved] Setter for non existing attributes on product edit don't rely on existing check

#0.2.38

- [changed] Changed user experience when associating categories to products

#0.2.37

- [fixed] Fixed some missing font awesome fonts
- [changed] When associating products to categories, an initial list will show on load
- [improved] Product name will now truncate if too long
- [improved] Reporting updates
- [improved] You can now have user fields set up to show on customer creation [1]

[1]
Just add this to your `config/getcandy.php` file:

```
    'users' => [
        'fields' => [
            'some_custom_field' => [
                'label' => 'Some Custom Field',
                'type' => 'text',
            ]
        ],
    ],
```

Any fields here will be shown when creating a customer and will go into the `fields` JSON column on `user_details`

#0.2.36

- [improved] Order view can handle multiple shipping lines

#0.2.35

- [fixed] Fixed pagination on customer table
- [improved] Improved customer name fetching on customer table.

#0.2.34

- [improved] Support meta fields from order on order listing table
- [changed] Column names generated from config items

#0.2.33

- [fixed] Fixed pagination on orders table
- [fixed] Fixed order error if shipping not present.

#0.2.32

- [fixed] Fixed Shipping Method edit screen
- [added] UI/Component tweaks across hub

#0.2.31

- [fixed] Make sure we can select a layout in the first instance

#0.2.30

- [fixed] Fixed issues with discount pagiation
- [fixed] Fixed issue with sub category creation

#0.2.29

- [added] Added refresh when adding a child category

#0.2.28

- [fixed] Fixed `X-CANDY-HUB` header not set on asset uploading

#0.2.27

- [added] Added an initial reports page
- [improved] Moved dashboard graphs/figures to ajax vue components

#0.2.26

- [fixed] Fixed issue when adding new shipping method prices
- [added] Overhaul to product listing including basic export/import functionality

#0.2.25

- [fixed] Fixed issue where customer group pricing didn't show properly for existing products with limited group pricing.

#0.2.24

- [fixed]  Fixed Customer Group Pricing not displaying on product edit

#0.2.23

- [added] Added `selected` event for tabbed content
- [added] Added refresh method for code mirror component

#0.2.22

- [fixed] Various fixes for editing and creating shipping methods.

#0.2.21

- [fixed] Fixes to collection editing
- [fixed] Fixes to product editing

#0.2.20

- [fixed] Account number didn't show on orders table
- [improved] Made shipping method and zone stand out on orders

#0.2.19

- [added] Added input for `min_batch`

#0.2.18

- [changed] Various changes to vue components

#0.2.17

- [fixed] Fixed issue that caused product families to not be editable

#0.2.16

- [fixed] Fixed some product variant editing anomolies
- [fixed] Fixed issue that prevented shipping prices from being added

#0.2.15

- [added] Added "view" link on orders table
- [fixed] Fixed issue where discounted line item was showing full line price on orders view
- [improved] Improved logic to show phone number on an order
- [added] Added handle on NavItem for catalogue manager so it can be listened to by plugins

#0.2.14

- [improved] Improved check for user details on activity log in the hub.

#0.2.13

- [fixed] Fixed issue where save wouldn't work on a category on the initial load.

#0.2.12

- [fixed] Fix trash icon in the hub

#0.2.11

- [fixed] Fix issue where unwanted attributes appeared while editing category

#0.2.10

- [added] Added ability for product families to be deleted and migrated in the hub
- [added] Added New\Returning flag against orders in listing.

#0.2.9

- [changed] Order table columns are now configurable
- [changed] Removed "Save order" button from order edit screen in favour of more specific button

#0.2.8

- [added] Added actions to allow moving a category across any child/parent
- [changed] Upgraded FontAwesome to latest version

#0.2.7

- [fixed] Fixed issue where input prop validation failed if a number was passed
- [fixed] Fixed issue where media listing wasn't showing thumbnails

#v0.2.6

- [fixed] Fixed issue where required attributes weren't indicated and also validation errors weren't displaying.
- [improved] The Rich text editor will now sanitize any weird HTML/tags from pasted content.

#v0.2.5

- [fixed] Stop duplicate attributes displaying on products

#v0.2.4

- [fixed] Fixed issue where product attribute groups weren't ordered the same as defined in the database.
- [added] Checks for CandyClient and adds session tokens.

#v0.2.3

- [fixed] Fixed product listing pagination
- [added] Added Favicon