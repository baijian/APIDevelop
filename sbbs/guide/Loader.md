Loaders
===

### What is Loader

Loaders is used to asynchronously load data in an activity
or fragment. Loaders will monitor the source of their data and
deliver new results when the content changes.

### Use Loader in your fragment

At the begining, you should know Class ```android.content.AsyncTaskLoader```,
write a abstract BaseClassLoader first.

It is very simple, blow is a base class and a demo class.

```java
pubilc abstract class BaseClassLoader<T> extends AsyncTaskLoader<T> {

    pubilc BaseClassLoader(Context context) {
        super(context);
    }

    public abstract T loadInBackground();

    @Override
    protected void onStartLoading() {
        forceLoad();
    }

    @Override
    public void onCanceled(T data) {
        super.onCanceled(data);
    }

    @Override
    protected void onStopLoading() {
        cancelLoad();
    }

    @Override
    protected void onReset() {
        stopLoading();
    }
}
```

Then write a loader class extends to BaseClassLoader, and T is the 
return type of data you will load. You can see it as ```Model``` of ```MVC```

```java
public class TestLoader extends BaseClassLoader<TestModel> {

    public TestLoader(Context context) {
        super(context);
    }

    public TestModel loadInBackground() {
        TestModel t = null;
        try {
            //this API maybe get contents from network.
            t = API.getTest();
        } catch (Exception e) {
            Log.e("loadInBackground", e.getMessage());
        }
        return t;
    }
}
```

At last, you will instance of the Loader in your fragment, and init
loader object in ```initComponents()``` method, then register it in
```initEvents()``` method, then in your ```initLogic()``` method of
your fragment you will start your load, done? No, your fragment should 
implements ```OnLoadCompleteListener``` interface, and use the data you load
to build your UI.

```java
@Override
public void initComponents() {
    loader = new TestLoader(getActivity());
}

@Override
public void initEvents() {
    loader.registerListener(0, this);
}

@Override
public void initLogic() {
    loader.startLoading();
}

@Override
public void onLoadComplete(Loader<TestModel> loader, TestModel data) {
    if (getActivity() != null) {
        if (data != null) {
            //here you can use data to build your UI.
        }
    }
}
```
