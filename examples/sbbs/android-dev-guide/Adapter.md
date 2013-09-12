Adapter
===

### What's the use of Adapter

Adapter in android are basically bridge between UI componets and the datasoure 
that fill data into UI Component.

The aim of adapter is to create only the necessary number of views to
fill the screen, and reuse these views as soon as they disappear.

```ViewHolder``` is a well known pattern to limit the number of calls
to ```findViewById``` in your ```getView``` method. So use ```Adapter``` together 
with ```Holder```.

### How to use adapter
