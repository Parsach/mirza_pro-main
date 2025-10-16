# 3X-UI Panel Integration Documentation

## Overview
This document describes the integration of 3X-UI panel support into the Mirza Pro bot system. The 3X-UI panel is a popular web-based management interface for Xray core that provides comprehensive VPN server management capabilities.

## Integration Components

### 1. Core Integration File: `3x-ui.php`
This file contains all the necessary functions to interact with the 3X-UI panel API:

#### Authentication Functions
- **`panel_login_3xui($code_panel)`**: Handles login to 3X-UI panel and retrieves session cookie
- **`login_3xui($code_panel, $verify = true)`**: Manages session persistence and re-authentication when needed

#### Inbound Management
- **`getInbounds_3xui($namepanel)`**: Retrieves list of all inbounds
- **`getInbound_3xui($namepanel, $inboundId)`**: Gets specific inbound details

#### Client Management
- **`addClient_3xui($namepanel, $username, $expire, $total, $uuid, $flow, $subId, $inboundId, $name_product, $note)`**: Creates new client
- **`updateClient_3xui($namepanel, $uuid, $config)`**: Updates existing client configuration
- **`deleteClient_3xui($namepanel, $uuid)`**: Removes client from panel
- **`getClientTraffic_3xui($namepanel, $email)`**: Retrieves client traffic statistics
- **`resetClientTraffic_3xui($namepanel, $email, $inboundId)`**: Resets client traffic counters

### 2. Panel Management Integration: `panels.php`
The following functions in `panels.php` have been extended to support 3X-UI:

#### User Operations
- **`createUser()`**: Creates new users in 3X-UI panel
- **`DataUser()`**: Retrieves user data and statistics
- **`RemoveUser()`**: Deletes users from the panel
- **`Modifyuser()`**: Updates user configurations

#### Status and Traffic Management
- **`Change_status()`**: Enables/disables user accounts
- **`ResetUserDataUsage()`**: Resets user traffic statistics

## Configuration Requirements

### Database Configuration
To use 3X-UI panel, add a panel entry in the `marzban_panel` table with:
- `type`: Set to `"3x-ui"`
- `url_panel`: Full URL to your 3X-UI panel (e.g., `http://your-server:54321`)
- `username_panel`: Admin username for 3X-UI
- `password_panel`: Admin password for 3X-UI
- `inboundid`: Default inbound ID to use for new clients
- `linksubx`: Subscription link base URL

### Optional Fields
- `twoFactorCode`: Two-factor authentication code if enabled on the panel
- `on_hold_test`: Set to `"1"` for test users with on-hold status
- `conecton`: Set to `"onconecton"` for immediate activation

## API Endpoints Used

The integration uses the following 3X-UI API endpoints:

1. **Authentication**
   - `POST /login/` - Login and get session cookie

2. **Inbound Management**
   - `GET /panel/api/inbounds/list` - List all inbounds
   - `GET /panel/api/inbounds/get/{inboundId}` - Get inbound details
   - `POST /panel/api/inbounds/update/{inboundId}` - Update inbound (used for adding/updating/deleting clients)

3. **Client Management**
   - `GET /panel/api/inbounds/getClientTraffics/{email}` - Get client traffic by email
   - `GET /panel/api/inbounds/getClientTrafficsById/{uuid}` - Get client traffic by UUID
   - `POST /{inboundId}/resetClientTraffic/{email}` - Reset client traffic

## Usage Examples

### Adding a New User
```php
$panel_name = "my_3xui_panel";
$username = "testuser";
$expire = time() + (30 * 86400); // 30 days
$data_limit = 10 * 1024 * 1024 * 1024; // 10GB
$config = [
    'expire' => $expire,
    'data_limit' => $data_limit,
    'from_id' => '123456',
    'username' => 'telegram_user',
    'type' => 'vless'
];

$manage = new ManagePanel();
$result = $manage->createUser($panel_name, "product_code", $username, $config);
```

### Getting User Information
```php
$manage = new ManagePanel();
$user_data = $manage->DataUser($panel_name, $username);
// Returns: status, username, data_limit, expire, used_traffic, links, subscription_url
```

### Modifying User
```php
$config = [
    'status' => 'active', // or 'disabled'
    'data_limit' => 20 * 1024 * 1024 * 1024, // 20GB
    'expire' => time() + (60 * 86400) // 60 days
];
$result = $manage->Modifyuser($username, $panel_name, $config);
```

## Features Supported

✅ **User Management**
- Create new users with custom configurations
- Update user settings (traffic limit, expiry time, status)
- Delete users
- Enable/disable user accounts

✅ **Traffic Management**
- Monitor user traffic usage
- Reset traffic counters
- Set traffic limits

✅ **Subscription Management**
- Generate subscription links
- Support for multiple protocols (VLESS, VMess, Trojan, etc.)
- Custom subscription paths

✅ **Session Management**
- Automatic session renewal
- Cookie-based authentication
- Session caching for performance

## Error Handling

The integration includes comprehensive error handling:
- Network connection errors
- Authentication failures
- Invalid user/panel configurations
- API response validation
- Graceful fallback mechanisms

## Security Considerations

1. **Credentials Storage**: Panel credentials are stored in the database and should be properly secured
2. **Session Management**: Sessions are cached for 5 hours to minimize authentication requests
3. **Cookie Files**: Temporary cookie files are automatically cleaned up after use
4. **Input Validation**: All user inputs are validated before API calls

## Limitations

1. The integration requires direct API access to the 3X-UI panel
2. Some advanced 3X-UI features may not be fully supported
3. Bulk operations are performed sequentially
4. Real-time connection status may have slight delays

## Troubleshooting

### Common Issues and Solutions

1. **Login Failed**
   - Verify panel URL is correct and accessible
   - Check username and password
   - Ensure two-factor authentication is properly configured if enabled

2. **User Creation Failed**
   - Verify inbound ID exists
   - Check if username already exists
   - Ensure panel has sufficient resources

3. **Traffic Reset Failed**
   - Confirm user exists in the panel
   - Check panel permissions
   - Verify inbound ID is correct

## Future Enhancements

Potential improvements for future versions:
- Bulk user operations
- Advanced traffic analytics
- Real-time connection monitoring
- Automatic inbound selection based on load
- Support for panel clustering

## Support

For issues or questions regarding the 3X-UI integration:
1. Check the error logs in the `error_log` file
2. Verify panel connectivity and credentials
3. Ensure the 3X-UI panel version is compatible
4. Review the API documentation at: https://github.com/MHSanaei/3x-ui

## Version History

- **v1.0.0** - Initial 3X-UI integration
  - Basic user management
  - Traffic monitoring
  - Session management
  - Error handling
