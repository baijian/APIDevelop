How to use CommonDevLib of rarnu
=======

* [How to use Fragment](#Fragment)

<h3 id="Fragment">Fragment</h3>

### What is Fragment?

A Fragment represents a behavior or a portion of user interface in
an Activity.So a fragment must always be embedded in an activity.
When you add a fragment as a part of your activity layout, it lives in
a **ViewGroup** inside the activity's view hierarchy. You can insert a 
fragment into your activity layout by declaring the fragment in the 
activity's layout file or from your application code by adding it to an 
existing **ViewGroup**.

### Fragment lifecycle

Always a fragment is added or replaced, it contains a lot callback methods.
In the order when fragment is created, *onAttach()* -> *onCreate()* -> *onCreateView()*
-> *onActivityCreated()* -> *onStart()* -> *onResume()*, then Fragment is active,
then *onPause()* -> *onStop()* -> *onDestroyView()* -> *onDestroy()* -> *onDetach()*, then 
fragment is destroyed.

And if you create a fragment you must override ***onCreateView()*** method.

### Write Fragment using CommonDevLib

First let us see *com.rarnu.devlib.base.inner.InnerFragment* class, this is the inner abstract
class extends to android abstract Fragment class.This abstract class have some attributes.

* protected View innerView => it is used when createView
* protected Bundle innerBundle => it is used when transfer params
* protected String tagText => also provide a get method to get this attribute
* protected String tagTitle => same as above

Then let's see onCreateView method, it inflates a view of it by invoke *getFragmentLayoutResId()*
method, then invoke some methods *initComponents()* *initEvents()*, then return the innerView.
These methods are all defined in *InnerIntf* interface, it's important. you will see it later.

Next see *onActivityCreated()* method, get some arguments and then invoke *initLogic()* method
also define in *InnerIntf* interface.

**Practice**

Write a fragment class extends to BaseFragment which is extends to InnerFragment class,
and all below methods you should implement.

```java
public class TestFragment extends BaseFragment {

    @Override
    public int getBarTitle() {
        return 0;
    }

    @Override
    public int getBarTitleWithPath() {
        return 0;
    }

    @Override
    public String getCustomTitle() {
        return null;
    }

    @Override
    public void initComponents() {

    }

    @Override
    public void initEvents() {

    }

    @Override
    public void initLogic() {

    }

    @Override
    public int getFragmentLayoutResId() {
        return 0;
    }

    @Override
    public String getMainActivityName() {
        return null;
    }

    @Override
    public void initMenu(Menu menu) {

    }

    @Override
    public void onGetNewArguments(Bundle bn) {

    }

    @Override
    public Bundle getFragmentState() {
        return null;
    }

}
```

Then add a constructor.

```java
public TestFragment() {
    //tagText is useful it represents the uniqueness of the fragment
    tagText = ResourceUtils.getString(R.tag.test_fragment);
}
```

Then implement three methods in order.

```java
@Override
public void initComponents() {
}

@Override 
public int initEvents() {
}

@Override
public String initLogic() {
}
```

OK, a basic fragment is done. 
I will add some explanation about fragment more continuously.
Waiting for it patiently
