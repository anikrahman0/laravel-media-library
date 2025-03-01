# Storage Disk Configuration Guide

This documentation outlines how to configure different storage disk options for your application. The available storage options are:

1. **Public Storage**
2. **MinIO (S3 Compatible Storage)**
3. **DigitalOcean Spaces (S3 Compatible Storage)**

If `STORAGE_DISK` is not explicitly defined in the environment file (`.env`), the system will default to using `public` storage.

## 1. Public Storage (Default)
The public storage disk is the default option. If `STORAGE_DISK` is not set, it will automatically default to `public`.

### **Environment Variables for Public Storage**
```ini
STORAGE_DISK=public
CDN_URL=http://medialibrary.test
```

### **Usage**
- The `public` disk stores media files inside Laravel's `storage/app/public` directory.
- It is served through `public_path()`.
- No additional credentials are required.
- The CDN URL can be defined to serve media files via a custom domain.

---

## 2. MinIO Storage (AWS S3 Compatible)
MinIO is an object storage service that follows the Amazon S3 API.

### **Environment Variables for MinIO**
```ini
STORAGE_DISK=minio
AWS_DISK=s3
AWS_ACCESS_KEY_ID=eMpfUmR3LWyn5u7rbdiu7a6ghk
AWS_SECRET_ACCESS_KEY=MsWrlFgTxvDmmVvVH0d8uPdojdya7xzRD6zK4gA3
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=demo24
AWS_USE_PATH_STYLE_ENDPOINT=true
AWS_ENDPOINT=https://bucket.demo.com
CDN_URL=https://cdn.demo.com/demo24
```

### **Usage**
- `AWS_DISK` is set to `s3`, meaning Laravel will use S3-compatible storage.
- `AWS_ENDPOINT` defines the MinIO or S3-compatible storage endpoint.
- `AWS_ACCESS_KEY_ID` and `AWS_SECRET_ACCESS_KEY` authenticate the storage service.
- The CDN URL can be configured to serve assets via a custom domain.

---

## 3. DigitalOcean Spaces Storage
DigitalOcean Spaces is an object storage service similar to AWS S3.

### **Environment Variables for DigitalOcean Spaces**
```ini
STORAGE_DISK=do_spaces
DO_SPACES_KEY=DOdDAHY$SJDIU&h
DO_SPACES_SECRET=zcxqqfygga5gY3rfTN41qIby/kcSFF3kVQk5hhOed
DO_SPACES_ENDPOINT=https://sgp1.digitaloceanspaces.com
DO_SPACES_REGION=SGP1
DO_SPACES_BUCKET=s3.demo24
CDN_URL=https://cdn.demo.com
```

### **Usage**
- `STORAGE_DISK=do_spaces` selects DigitalOcean Spaces as the storage backend.
- `DO_SPACES_ENDPOINT` specifies the region and endpoint for the storage service.
- `DO_SPACES_KEY` and `DO_SPACES_SECRET` authenticate the connection.
- The CDN URL can be used to serve files via DigitalOcean’s built-in CDN.

---

## Default Behavior
If `STORAGE_DISK` is not set in the `.env` file, the system will use `public` as the default disk. This ensures that the application remains functional even without a configured storage backend.

### **Example Default Behavior**
```ini
# No STORAGE_DISK defined
# The application will default to public storage
```

---

## Conclusion
- **Use `public` storage** if you want local file storage with Laravel.
- **Use `minio` storage** for S3-compatible services like MinIO or AWS S3.
- **Use `do_spaces` storage** if you are using DigitalOcean Spaces.
- Always configure the `CDN_URL` if you plan to serve files via a CDN.
- If `STORAGE_DISK` is not defined, `public` will be used as the default storage option.

This setup ensures a flexible and scalable media storage solution for your Laravel application.

